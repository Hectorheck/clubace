<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Support\Facades\URL;

class VerifyApiEmail extends VerifyEmailBase
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
	// 	//
	// }

	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
		'verificationapi.verify', date_create()->modify('+ 60 minutes'), ['id' => $notifiable->getKey()]);
		// this will basically mimic the email endpoint with get request
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	// public function via($notifiable)
	// {
	// 	return ['mail'];
	// }

	// /**
	//  * Get the mail representation of the notification.
	//  *
	//  * @param  mixed  $notifiable
	//  * @return \Illuminate\Notifications\Messages\MailMessage
	//  */
	// public function toMail($notifiable)
	// {
	// 	return (new MailMessage)
	// 		->subject(Lang::get('Verify Email'))
	// 		->line(Lang::get('You are receiving this email because we need to verify your account.'))
	// 		->action(Lang::get('Verify Email'), $this->verificationUrl())
	// 		// ->line('The introduction to the notification.')
	// 		// ->action('Notification Action', url('/'))
	// 		// ->line('Thank you for using our application!');
	// }

	// /**
	//  * Get the array representation of the notification.
	//  *
	//  * @param  mixed  $notifiable
	//  * @return array
	//  */
	// public function toArray($notifiable)
	// {
	// 	return [
	// 		//
	// 	];
	// }
}
