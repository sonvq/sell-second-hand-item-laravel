<html>
    <head>
        <title>
            {{ trans('appuser::appusers.title.user export sheet name') }}
        </title>
    </head>
    <body>
        <div class="panel-body">
            <table class="table table-striped table-condensed table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('appuser::appusers.table.id') }}</th>
                        <th>{{ trans('appuser::appusers.table.username') }}</th>
                        <th>{{ trans('appuser::appusers.table.fullname') }}</th>
                        <th>{{ trans('appuser::appusers.table.email') }}</th>
                        <th>{{ trans('appuser::appusers.table.mobile') }}</th>
                        <th>{{ trans('appuser::appusers.table.gender') }}</th>
                        <th>{{ trans('appuser::appusers.table.date_of_birth') }}</th>                                
                        <th>{{ trans('appuser::appusers.table.city') }}</th>
                        <th>{{ trans('appuser::appusers.table.report user?') }}</th>
                        <th>{{ trans('appuser::appusers.table.total_reported_case') }}</th> 
                        <th>{{ trans('appuser::appusers.table.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($appusers) && (count($appusers) > 0)): ?>
                        <?php foreach ($appusers as $appuser): ?>
                            <tr>
                                <td>
                                    {{ $appuser->id }}
                                </td>
                                <td>
                                    {{ $appuser->username }}
                                </td>
                                <td>
                                    {{ $appuser->full_name }}
                                </td>
                                <td>
                                    {{ $appuser->email }}
                                </td>
                                <td>
                                    {{ $appuser->phone_number }}
                                </td>
                                <td>
                                    @if ($appuser->gender == 'male')
                                        Male
                                    @else 
                                        Female
                                    @endif
                                </td>
                                <td>
                                    {{ date('d/m/Y', strtotime($appuser->date_of_birth)) }}
                                </td>
                                <td>
                                    <?php $cityUser = $appuser->city; ?>
                                    @if ($cityUser)
                                        {{ $cityUser->name }}
                                    @endif
                                </td>   
                                <td>
                                    @if ($appuser->report_receiver->count() > 0)
                                        Y
                                    @else
                                        N
                                    @endif
                                </td>
                                <td>
                                    {{ $appuser->report_receiver->count() }}
                                </td>
                                <td>
                                    @if ($appuser->status == 'active')
                                        Active
                                    @elseif ($appuser->status == 'inactive')
                                        Inactive
                                    @endif
                                </td>                                 
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </body>
</html>