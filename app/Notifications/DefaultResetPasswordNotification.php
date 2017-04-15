<?php

namespace CodeFlix\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Redefinição de senha')
            ->line('Você esta recebendo esse email porque uma redefinição de senha foi requisitada para sua conta.')
            ->action('Redefinir senha', route('password.reset', $this->token))
            ->line('Se você não requisitou isso, por favor desconsidere esse email.');
    }
}
