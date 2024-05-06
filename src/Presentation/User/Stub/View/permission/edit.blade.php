@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Modify permission'),
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => 'lp.admin.permission.index',
                'name' => __('Permission'),
            ],
            [
                'link' => '#',
                'name' => __('Modify permission'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('lp.admin.permission.update', $permission->id) }}">
                    {{ method_field('PUT') }}
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $permission->name }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $permission->title }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="module">{{ __('Module name') }}</label>
                                <input type="text" class="form-control" name="module" id="module"
                                    value="{{ $permission->module }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="guard_name">{{ __('Guard name') }}</label>
                                <select class="form-control" name="guard_name" id="guard_name">
                                    <option selected>web</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ $permission->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">{{ __('Submit') }}</button>
                    <a href="{{ route('lp.admin.permission.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
