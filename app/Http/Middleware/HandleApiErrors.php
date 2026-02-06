<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Middleware for handling API errors consistently
 */
class HandleApiErrors
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (NotFoundHttpException $e) {
            return $this->notFoundResponse();
        } catch (MethodNotAllowedHttpException $e) {
            return $this->methodNotAllowedResponse();
        } catch (HttpException $e) {
            return $this->httpErrorResponse($e);
        } catch (\Exception $e) {
            return $this->genericErrorResponse($e);
        }
    }

    /**
     * Return validation error response
     *
     * @param ValidationException $e
     * @return JsonResponse
     */
    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }

    /**
     * Return not found response
     *
     * @return JsonResponse
     */
    private function notFoundResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found',
        ], 404);
    }

    /**
     * Return method not allowed response
     *
     * @return JsonResponse
     */
    private function methodNotAllowedResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Method not allowed',
        ], 405);
    }

    /**
     * Return HTTP error response
     *
     * @param HttpException $e
     * @return JsonResponse
     */
    private function httpErrorResponse(HttpException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], $e->getStatusCode());
    }

    /**
     * Return generic error response
     *
     * @param \Exception $e
     * @return JsonResponse
     */
    private function genericErrorResponse(\Exception $e): JsonResponse
    {
        \Log::error('API Error: ' . $e->getMessage(), [
            'exception' => $e,
            'request' => request()->fullUrl(),
            'method' => request()->method(),
        ]);

        return response()->json([
            'success' => false,
            'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
        ], 500);
    }
}
