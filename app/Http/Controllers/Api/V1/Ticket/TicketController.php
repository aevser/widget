<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Ticket\CreateTicketRequest;
use App\Http\Resources\V1\Ticket\IndexTicketResource;
use App\Services\Ticket\TicketService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Tickets API",
    description: "API для управления обращениями"
)]
#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local server"
)]
class TicketController extends Controller
{
    public function __construct(private TicketService $ticketService){}

    #[OA\Post(
        path: "/api/v1/tickets",
        summary: "Создать обращение",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["name", "email", "phone", "subject", "message"],
                    properties: [
                        new OA\Property(property: "name", type: "string", example: "Иван Иванов"),
                        new OA\Property(property: "email", type: "string", example: "ivan@example.com"),
                        new OA\Property(property: "phone", type: "string", example: "+79991234567"),
                        new OA\Property(property: "subject", type: "string", example: "Вопрос по заказу"),
                        new OA\Property(property: "message", type: "string", example: "Текст сообщения"),
                        new OA\Property(
                            property: "files[]",
                            type: "array",
                            items: new OA\Items(type: "string", format: "binary"),
                            description: "Файлы (макс. 5 шт, до 10 МБ)"
                        )
                    ]
                )
            )
        ),
        tags: ["Tickets"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Обращение создано",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string"),
                        new OA\Property(property: "errors", type: "object")
                    ]
                )
            )
        ]
    )]
    public function store(CreateTicketRequest $request): JsonResponse
    {
        $result = $this->ticketService->create($request->validated(), attachments: $request->file('files'));

        return response()->json(['success' => true, 'message' => 'Ваше обращение успешно отправлено! Мы свяжемся с вами в ближайшее время.',
            'data' => IndexTicketResource::make($result)
        ], JsonResponse::HTTP_CREATED);
    }
}
