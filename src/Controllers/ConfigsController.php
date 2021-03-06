<?php

namespace Varbox\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Varbox\Contracts\ConfigFilterContract;
use Varbox\Contracts\ConfigModelContract;
use Varbox\Contracts\ConfigSortContract;
use Varbox\Requests\ConfigRequest;
use Varbox\Traits\CanCrud;

class ConfigsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use CanCrud;

    /**
     * @var ConfigModelContract
     */
    protected $model;

    /**
     * ConfigsController constructor.
     *
     * @param ConfigModelContract $model
     */
    public function __construct(ConfigModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @param ConfigFilterContract $filter
     * @param ConfigSortContract $sort
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request, ConfigFilterContract $filter, ConfigSortContract $sort)
    {
        return $this->_index(function () use ($request, $filter, $sort) {
            $this->items = $this->model
                ->filtered($request->all(), $filter)
                ->sorted($request->all(), $sort)
                ->paginate(config('varbox.crud.per_page', 30));

            $this->title = 'Configs';
            $this->view = view('varbox::admin.configs.index');
            $this->vars = [
                'keys' => $this->model->getAllowedKeys()
            ];
        });
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function create()
    {
        return $this->_create(function () {
            $this->title = 'Add Config';
            $this->view = view('varbox::admin.configs.add');
            $this->vars = [
                'keys' => $this->model->getAllowedKeys()
            ];
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        app(config('varbox.bindings.form_requests.config_form_request', ConfigRequest::class));

        return $this->_store(function () use ($request) {
            $this->item = $this->model->create($request->all());
            $this->redirect = redirect()->route('admin.configs.index');
        }, $request);
    }

    /**
     * @param ConfigModelContract $config
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function edit(ConfigModelContract $config)
    {
        return $this->_edit(function () use ($config) {
            $this->item = $config;
            $this->title = 'Edit Config';
            $this->view = view('varbox::admin.configs.edit');
            $this->vars = [
                'keys' => $this->model->getAllowedKeys()
            ];
        });
    }

    /**
     * @param Request $request
     * @param ConfigModelContract $config
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, ConfigModelContract $config)
    {
        app(config('varbox.bindings.form_requests.config_form_request', ConfigRequest::class));

        return $this->_update(function () use ($request, $config) {
            $this->item = $config;
            $this->redirect = redirect()->route('admin.configs.index');

            $this->item->update($request->all());
        }, $request);
    }

    /**
     * @param ConfigModelContract $config
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ConfigModelContract $config)
    {
        return $this->_destroy(function () use ($config) {
            $this->item = $config;
            $this->redirect = redirect()->route('admin.configs.index');

            $this->item->delete();
        });
    }
}
