<?php

namespace ZohoSubscriptions\Support\Token;

use MacsiDigital\OAuth2\Support\Token\Base;
use MacsiDigital\OAuth2\Integration;

class DB extends Base
{
    protected $model;
    protected $additional;

    public function __construct($integration)
    {
        $this->model = Integration::firstOrNew([
            'name' => $integration
        ]);
        $this->integration = $integration;
        $this->setFromModel($this->model);
    }

    public function setFromModel($model)
    {
        $this->setAccessToken($model->accessToken);
        $this->setRefreshToken($model->refreshToken);
        $this->setExpires($model->expires);
        $this->setAdditional($model->additional ?? []);

        return $this;
    }

    public function setAdditional(array $additional)
    {
        $this->additional = $additional;

        return $this;
    }

    public function additional()
    {
        return $this->additional;
    }

    public function save()
    {
        $this->model->accessToken = $this->accessToken();
        $this->model->expires = $this->expires();
        $this->model->additional = $this->additional();

        if ($this->refreshToken()) {
            $this->model->refreshToken = $this->refreshToken();
        }

        $this->model->save();

        return $this;
    }

    public function updateAccessToken($accessToken)
    {
        $this->set([
            'accessToken' => $accessToken->getToken(),
            'expires' => $accessToken->getExpires(),
        ]);

        if ($accessToken->getRefreshToken()) {
            $this->set([
                'refreshToken' => $accessToken->getRefreshToken(),
            ]);
        }

        return $this->save();
    }
}
