<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $complaint;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint)
    {
       $this->complaint = $complaint;
    }
     public function build()
    {
        return $this->subject('Pengaduan Anda Telah Diterima - ' . $this->complaint->ticket_number)
                    ->view('emails.complaint-submitted')
                    ->with([
                        'ticketNumber' => $this->complaint->ticket_number,
                        'reporterName' => $this->complaint->reporter_name,
                        'subject' => $this->complaint->subject,
                        'service' => $this->complaint->service->name,
                        'createdAt' => $this->complaint->created_at->format('d M Y H:i'),
                        'trackingUrl' => route('public.complaints.show', $this->complaint->ticket_number)
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complaint Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
