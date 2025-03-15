<?php

namespace App\Mail;

use App\Models\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FuelLeakAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Alert $alert,
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Fuel Leak Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $alert = $this->alert->load([
            'customAlert.storageTank', 
            'mq2Reading',
            'bmp180Reading'
        ]);
        
        return new Content(
            view: 'emails.fuel-leak-alert',
            with: [
                'alertId' => $alert->id,
                'alertStatus' => $alert->status,
                'mq2Reading' => $alert->mq2Reading->value,
                'bmp180Reading' => $alert->bmp180Reading->value,
                'alertLevel' => $alert->customAlert->level,
                'description' => $alert->customAlert->description,
                'actionRequired' => $alert->customAlert->action_required,
                'tankIdentifier' => $alert->customAlert->storageTank->identifier,
                'location' => $alert->customAlert->storageTank->location,
                'fuelType' => $alert->customAlert->storageTank->fuel_type,
                'triggeredAt' => $alert->triggered_at,
                'mq2Min' => $alert->customAlert->mq2_min,
                'mq2Max' => $alert->customAlert->mq2_max,
                'bmp180Min' => $alert->customAlert->bmp180_min,
                'bmp180Max' => $alert->customAlert->bmp180_max,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
