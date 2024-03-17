<?php

namespace Juzaweb\CMS\Support;

use Exception;
use Illuminate\Support\Facades\Mail;
use Juzaweb\Backend\Models\EmailList;
use Illuminate\Support\Facades\Http;

class SendEmail
{
    protected EmailList $mail;

    public function __construct(EmailList $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Send email by row email_lists table
     *
     * @return bool
     * @throws Exception
     */
    public function send(): bool
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $this->updateError($validate);
            return false;
        }

        $this->updateStatus('processing');

        try {
            $body = $this->mail->getBody();
            $subject = $this->mail->getSubject();

            $client_id = get_config('email.client_id');
            $tenant_id = get_config('email.tenant_id');
            $client_secret = get_config('email.client_secret');
            if ($client_id != "" && $tenant_id != "" && $client_secret != "") {
                $oauth_token = $this->getOAuthToken($client_id, $client_secret, $tenant_id);
                if ($oauth_token) {
                    $userPrincipalName = config('mail.username');
                    $graphUrl = "https://graph.microsoft.com/v1.0/users/$userPrincipalName/sendMail";
                    $message = [
                        "message" => [
                            "subject" => $subject,
                            "body" => [
                                "contentType" => "HTML",
                                "content" => $body,
                            ],
                            "toRecipients" => [
                                ["emailAddress" => ["address" => $this->mail->email]],
                            ],
                        ],
                    ];

                    $response = Http::withToken($oauth_token)->post($graphUrl, $message);
                }
            } else {
                Mail::send(
                    'cms::backend.email.layouts.default',
                    [
                        'body' => $body,
                    ],
                    function ($message) use ($subject) {
                        $message->to([$this->mail->email])
                            ->subject($subject);
                    }
                );
            }

            /*if (Mail::failures()) {
                $this->updateError(array_merge([
                    'title' => 'Mail failures',
                ], Mail::failures()));

                return false;
            }*/

            $this->updateStatus('success', $subject, $body);

            return true;
        } catch (Exception $e) {
            $this->updateError(
                [
                    'title' => 'Send mail exception',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                ]
            );

            if (config('app.debug')) {
                throw $e;
            }
            report($e);
            return false;
        }
    }

    protected function updateStatus(
        string $status,
        $subject = null,
        $body = null
    ): bool {
        $update = [
            'status' => $status
        ];

        if ($subject && $body) {
            $data = $this->mail->data;
            $data['subject'] = $subject;
            $data['body'] = $body;
            $update['data'] = $data;
        }

        return $this->mail->update($update);
    }

    protected function updateError(array $error = []): bool
    {
        return $this->mail->update(
            [
                'error' => $error,
                'status' => 'error',
            ]
        );
    }

    /**
     * Send mail validate
     *
     * @return bool|array
     */
    protected function validate(): bool|array
    {
        return true;
    }
    protected function getOAuthToken($clientId, $clientSecret, $tenantId)
    {

        $graphUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";

        $response = Http::asForm()->post($graphUrl, [
            'client_id' => $clientId,
            'scope' => 'https://graph.microsoft.com/.default',
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        $accessToken = $response['access_token'];
        return $accessToken;
    }
}
