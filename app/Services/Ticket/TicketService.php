<?php

namespace App\Services\Ticket;

use App\Enums\TicketStatus;
use App\Models\Ticket\Ticket;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Ticket\TicketStatusRepository;
use App\Services\Ticket\TicketAttachment\TicketAttachmentService;

class TicketService
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private TicketRepository $ticketRepository,
        private TicketStatusRepository $ticketStatusRepository,
        private TicketAttachmentService $ticketAttachmentService,
        private TicketValidationService $ticketValidationService
    ){}

    public function create(array $data, ?array $attachments = null): Ticket
    {
        $this->ticketValidationService->validateLimit(phone: $data['phone'], email: $data['email']);

        $customer = $this->customerRepository->findOrCreate(name: $data['name'], phone: $data['phone'], email: $data['email']);

        $ticket = $this->ticketRepository->create(
            customerId: $customer->id,
            statusId: $this->ticketStatusRepository->findIdByType(TicketStatus::NEW->value),
            subject: $data['subject'],
            message: $data['message']
        );

        if ($attachments && count($attachments) > 0) { $this->ticketAttachmentService->addFiles(ticket: $ticket, uploadedFiles: $attachments); }

        return $ticket;
    }
}
