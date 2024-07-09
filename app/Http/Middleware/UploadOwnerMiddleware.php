<?php

namespace App\Http\Middleware;

use App\Const\ImageType;
use App\Helper\UploadHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadOwnerMiddleware
{
    public function __construct(
        private UploadHelper $uploadHelper,
    ){
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $imageType = $request->query('type');
        if(!ImageType::isValid($imageType)) {
            return $next($request);
        }

        $ownerId = $request->route()->parameter('owner');
        $ownerRepository = $this->uploadHelper->getRepository($imageType);

        $owner = $ownerRepository->findOneBy(['id' => $ownerId]);

        $request->route()->setParameter('owner', $owner);

        return $next($request);
    }
}
