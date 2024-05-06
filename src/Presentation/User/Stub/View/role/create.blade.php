@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Create a new role'),
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => 'lp.admin.role.index',
                'name' => __('Roles'),
            ],
            [
                'link' => '#',
                'name' => __('New role'),
            ],
        ],
    ])
@endsection

@section('content')
    <form class="forms-sample" method="POST" action="{{ route('lp.admin.role.store') }}">
        @csrf

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Name like: Admin">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Title like: Admin Manager">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="guard_name">{{ __('Guard name') }}</label>
                                <select class="form-control" name="guard_name" id="guard_name">
                                    <option value="web" selected>web</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Permissions') }}</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                @forelse ($permissions as $item)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="permissions[]" value="{{ $item->name }}"
                                                class="form-check-input">
                                            {{ $item->title . ($item->description ? '  [ ' . $item->description . ' ]' : '') }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @empty
                                    ----
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 grid-margin stretch-card">
            <button type="submit" class="btn btn-gradient-primary mr-2">{{ __('Submit') }}</button>
            <a href="{{ route('lp.admin.role.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection


@section('footer')
    @parent
@endsection
