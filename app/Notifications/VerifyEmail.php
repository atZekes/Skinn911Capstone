<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Skin911 Account 🎉')
            ->greeting('Welcome to Skin911!')
            ->line('Thank you for creating an account with **Skin911** - your premier skincare destination! ✨')
            ->line('We\'re excited to have you join our community. To get started with booking amazing skincare services, please verify your email address by clicking the button below:')
            ->action('Verify Email Address', $verificationUrl)
            ->line('This verification link will expire in 60 minutes for your security.')
            ->line('Once verified, you\'ll be able to:')
            ->line('✅ Book appointments at any of our branches')
            ->line('✅ Access exclusive skincare services')
            ->line('✅ Manage your bookings and profile')
            ->line('✅ Receive special offers and updates')
            ->line('If you did not create an account with Skin911, no further action is required. Please disregard this email.')
            ->salutation('Best regards,  
**The Skin911 Team**  
_Your Skin, Our Priority_

📧 skin911.mainofc@gmail.com  
📱 Follow us: [Facebook](https://www.facebook.com/Skin911Official/) | [Instagram](https://www.instagram.com/skin911/)');
    }
}
