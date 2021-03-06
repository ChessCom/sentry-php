<?php

declare(strict_types=1);

namespace Sentry\Integration;

use Sentry\ErrorHandler;
use Sentry\State\Hub;

/**
 * This integration hooks into the global error handlers and emits events to
 * Sentry.
 */
final class ExceptionListenerIntegration implements IntegrationInterface
{
    /**
     * {@inheritdoc}
     */
    public function setupOnce(): void
    {
        $errorHandler = ErrorHandler::registerOnce(ErrorHandler::DEFAULT_RESERVED_MEMORY_SIZE, false);
        $errorHandler->addExceptionHandlerListener(static function (\Throwable $exception): void {
            Hub::getCurrent()->captureException($exception);
        });
    }
}
