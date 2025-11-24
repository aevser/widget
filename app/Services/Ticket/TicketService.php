<?php

namespace App\Services\Ticket;

use App\Enums\TicketStatus;
use App\Models\Ticket\Ticket;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Ticket\TicketStatusRepository;
use App\Services\Ticket\Attachment\TicketAttachmentService;

class TicketService
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private TicketRepository $ticketRepository,
        private TicketStatusRepository $ticketStatusRepository,
        private TicketAttachmentService $ticketAttachmentService
    ){}

    public function create(array $data, ?array $attachments = null): Ticket
    {
        $customer = $this->customerRepository->findOrCreate(name: $data['name'], phone: $data['phone'], email: $data['email']);

        $ticket = $this->ticketRepository->create(
            user_id:  null,
            customer_id: $customer->id,
            status_id: $this->ticketStatusRepository->findIdByType(TicketStatus::NEW->value),
            subject: $data['subject'],
            message: $data['message'],
            manager_replied_at: null
        );

        if ($attachments && count($attachments) > 0) { $this->ticketAttachmentService->addFiles(ticket: $ticket, uploadedFiles: $attachments); }

        return $ticket;
    }
}
