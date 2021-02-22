<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Api;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Http\Requests\Api\Term\CreateTermRequest;
use CzechitasApp\Http\Requests\Api\Term\UpdateTermRequest;
use CzechitasApp\Models\Term;
use CzechitasApp\Services\Models\TermService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TermController extends Controller
{
    /** @var TermService */
    protected $termService;

    public function __construct(TermService $termService)
    {
        $this->termService = $termService;
    }

    public function index(Request $request): Response
    {
        $this->authorize('list', Term::class);

        return \response()->json($this->termService->getApiList(
            (int)$request->query('page', '1'),
            (int)$request->query('perPage', '50')
        )->get(['id', 'category_id', 'start', 'end', 'opening', 'price']));
    }

    public function show(Term $term): Response
    {
        $this->authorize('view', $term);

        return \response()->json($term);
    }

    public function store(CreateTermRequest $request): Response
    {
        $this->authorize('create', Term::class);
        $term = $this->termService->insert($request->getData());

        return \response()->json($term, Response::HTTP_CREATED);
    }

    public function update(UpdateTermRequest $request, Term $term): Response
    {
        $this->authorize('update', $term);
        $this->termService->setContext($term)->update($request->getData());

        return \response()->json($this->termService->getContext(), Response::HTTP_ACCEPTED);
    }

    public function destroy(Term $term): Response
    {
        $this->authorize('delete', $term);
        $this->termService->setContext($term)->delete();

        return \response()->json('OK', Response::HTTP_OK);
    }
}
