<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $oldStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint, $oldStatus = null)
    {
        $this->complaint = $complaint;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Update Status Pengaduan - ' . $this->complaint->ticket_number)
                    ->view('emails.complaint-status-updated')
                    ->with([
                        'ticketNumber' => $this->complaint->ticket_number,
                        'reporterName' => $this->complaint->reporter_name,
                        'subject' => $this->complaint->subject,
                        'status' => $this->complaint->status_label,
                        'response' => $this->complaint->response,
                        'trackingUrl' => route('public.complaints.show', $this->complaint->ticket_number)
                    ]);
    }
}