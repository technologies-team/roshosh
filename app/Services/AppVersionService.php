<?php

namespace App\Services;

use App\Models\AppVersion;

class AppVersionService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['device_type','version','application_type','message'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['device_type','version','application_type','message'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['device_type'];

    /**
     * 
     */
    protected array $with = [];


    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return AppVersion::query();
    }

    public function app_version(array $attributes){
        $response = "";
        try {
            $device_type = $attributes['device_type'];
            $app_version= $attributes['version'];
            $device_version = $this->builder()->where("device_type", $device_type)->first();
            if ($device_version) {
                if($device_version->version === $app_version) {
                    $response = array(
                        "status" => true,
                        "data" => array(
                            "version" => $device_version->version
                        ),
                        "errors" => array()
                    );

                }
                else {
                    $response = array(
                        "status" => false,
                        "data" => array(
                            "version" => $device_version->version,
                            "device_type" => $device_version->device_type,
                            "application_type" => $device_version->application_type,
                            "message"=> $device_version->message
                        ),
                        "errors" => array());
                }

        } 
        else {
                $response = array(
                    "status" => false,
                    "data" => null,
                    "errors" => array(
                        array(
                            "message" => "Device version not found"
                        )
                    )
                );
            }
        }
        catch (\Exception $e) {
            $response = array(
                "status" => false,
                "data" => null,
                "errors" => array(
                    array(
                        "message" => "Something went wrong, $e"
                    )
                )
            );
        }

        return $this->ok($response, 'App Version retrieved successfully');

    }
}
