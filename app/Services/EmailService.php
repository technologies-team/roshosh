<?php


namespace App\Services;

use App\DTOs\Result;
use App\Mail\templates\ResetPasswordMail;
use App\Mail\templates\WelcomeEmail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Exception;

class EmailService extends ModelService
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return PasswordResetToken::query();
    }


    // function that send email to user
    public function sendEmail(string $email, $mailInstance): void
    {
        try {
            Mail::to($email)->send($mailInstance);
        } catch (Exception $exception) {
            dd($exception);
        }
    }

    // send welcome mail to user
    public function sendWelcomeMail($user): Result
    {
        // call send email function
        if(isset($user->email)) {
            $this->sendEmail($user->email , new WelcomeEmail($user->name));
        }
        return $this->ok('message', 'welcome:message:sent');
    }

    // send reset password email

    /**
     * @throws \Exception
     */
    public function sendResetPasswordMail(array $attributes): Result
    {
        $email = $attributes['email'];
        $user = $this->userService->getUserBy("email",$email);
        if ($user instanceof User) {
            //this function generate number for 6 digits
            $random_string = random_int(100000, 999999);;
            //$random_string = "123456789";
            $user->resetToken()->delete();

            // save random code to  table
            $user->resetToken()->create([
                    'email' => $user->email,
                    'token' => $random_string,
                    'created_at' => now(),
            ]);
            // call send email function
            $this->sendEmail($email, new ResetPasswordMail($random_string));

        } else throw new \Exception('user:email:not:found');

        return $this->ok('message', 'reset:message:sent');
    }

    /**
     * @throws \Exception
     */
    public function getToken(array $attribute): Result
    {
        $email = $attribute['email'];
        $user = $this->userService->getUserBy("email",$email);
        if ($user instanceof User) {
            $meta = $user->resetToken()->get()->first();
            if ($meta instanceof PasswordResetToken) {
                if ($meta->token == $attribute["reset_code"]) {
                    $user->update(["password" => $attribute["new_password"]]);
                    $user->resetToken()->delete();

                    return $this->ok($user, 'records password update done');
                } else
                    throw new \Exception('code not found');
            } else
                throw new \Exception('user email not found');
        } else
            throw new \Exception('user email not found');
    }

    /**
     * @throws \Exception
     */
    public function checkOtp(array $attribute): Result
    {
        $email = $attribute['email'];
        $user = $this->userService->getUserBy("email",$email);
        if ($user instanceof User) {
            $meta = $user->resetToken()->get()->first();
            if ($meta instanceof PasswordResetToken) {
                if ($meta->token == $attribute["reset_code"]) {
                    return $this->ok( [],'token is correct');
                } else
                    throw new \Exception('code not found');
            } else
                throw new \Exception('user email not found');
        } else
            throw new \Exception('user email not found');
    }

}
