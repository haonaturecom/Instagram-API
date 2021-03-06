<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;
use InstagramAPI\Signatures;

/**
 * Functions related to registration. We DO NOT and WILL NOT support account creation.
 */
class Registration extends RequestCollection
{
    /**
     * Check if Instagram username is available.
     *
     * @param string $username Instagram username.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CheckUsernameResponse
     */
    public function checkUsername(
        $username)
    {
        $request = $this->ig->request('users/check_username/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('username', $username)
            ->addPost('_csrftoken', $this->ig->client->getToken());

        if ($this->ig->username === \InstagramAPI\Instagram::ANONYMOUS_USER) {
            $request->setNeedsAuth(false);
        } else {
            $request->addPost('_uid', $this->ig->account_id);
        }

        $request->getResponse(new Response\CheckUsernameResponse());
    }

    /**
     * Check if email is available.
     *
     * @param string $email Email account.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CheckEmailResponse
     */
    public function checkEmail(
        $email)
    {
        $request = $this->ig->request('users/check_email/')
            ->addPost('qe_id', Signatures::generateUUID(true))
            ->addPost('waterfall_id', Signatures::generateUUID(true))
            ->addPost('email', $email)
            ->addPost('_csrftoken', $this->ig->client->getToken());

        if ($this->ig->username === \InstagramAPI\Instagram::ANONYMOUS_USER) {
            $request->setNeedsAuth(false);
        } else {
            $request->addPost('_uid', $this->ig->account_id);
        }

        $request->getResponse(new Response\CheckEmailResponse());
    }
}
