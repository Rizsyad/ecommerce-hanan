<?php

namespace App\Mail;

use App\Models\OrderItems;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $orderItems;
    protected $detailInfo;

    /**
     * Create a new message instance.
     */
    public function __construct($orderItems, $detailInfo)
    {
        $this->orderItems = $orderItems;
        $this->detailInfo = $detailInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('admin@hananan.store', 'Hanan Store'),
            subject: 'Invoice Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.invoice',
            // view: 'mails.invoice_testing',
            with: [
                'orderItems' => $this->orderItems,
                'detailInfo' => $this->detailInfo
            ],
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
