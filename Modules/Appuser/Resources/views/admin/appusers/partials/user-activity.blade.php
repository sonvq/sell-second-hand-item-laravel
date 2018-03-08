<div class="box-body">
    <div class="table-responsive">
        <table class="data-table table table-bordered table-hover">
            <thead>
            <tr>
                <th>{{ trans('appuser::appusers.table.id sharp') }}</th>
                <th>{{ trans('appuser::appusers.table.action') }}</th>
                <th>{{ trans('appuser::appusers.table.item id') }}</th>
                <th>{{ trans('appuser::appusers.table.item title') }}</th>
                <th>{{ trans('appuser::appusers.table.timestamp') }}</th>               
            </tr>
            </thead>
            <tbody>
            <?php if (isset($activities)): ?>
                <?php $count = 1; ?>
                <?php foreach ($activities as $item): ?>
                    <tr>   
                        <td>
                            {{ $count }}
                        </td>
                        <td>
                            {{ $item->action }}
                        </td>
                        <td>
                            <?php $itemObject = $item->item; ?>
                            @if ($itemObject)
                                {{ $itemObject->id }}
                            @endif
                        </td> 
                        <td>
                            <?php $itemObject = $item->item; ?>
                            @if ($itemObject)
                                {{ $itemObject->title }}
                            @endif
                        </td>  
                        <td>
                            {{ date('d/m/Y H:i', strtotime($item->log_time)) }}
                        </td>                          
                    </tr>
                    <?php $count++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <th>{{ trans('appuser::appusers.table.id sharp') }}</th>
                <th>{{ trans('appuser::appusers.table.action') }}</th>
                <th>{{ trans('appuser::appusers.table.item id') }}</th>
                <th>{{ trans('appuser::appusers.table.item title') }}</th>
                <th>{{ trans('appuser::appusers.table.timestamp') }}</th>  
            </tr>
            </tfoot>
        </table>
        <!-- /.box-body -->
    </div>
</div>
