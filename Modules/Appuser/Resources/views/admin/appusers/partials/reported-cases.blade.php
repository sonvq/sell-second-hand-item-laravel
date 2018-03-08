<div class="box-body">
    <div class="table-responsive">
        <table class="data-table table table-bordered table-hover">
            <thead>
            <tr>
                <th>{{ trans('reporting::reportings.table.id') }}</th>
                <th>{{ trans('reporting::reportings.table.reported by') }}</th>
                <th>{{ trans('reporting::reportings.table.item title') }}</th>
                <th>{{ trans('reporting::reportings.table.time') }}</th>
                <th>{{ trans('reporting::reportings.table.message') }}</th>               
            </tr>
            </thead>
            <tbody>
            <?php if (isset($reportedCase)): ?>
                <?php foreach ($reportedCase as $item): ?>
                <tr>   
                    <td>
                        {{ $item->id }}
                    </td>
                    <td>
                        <?php $senderObject = $item->sender; ?>                        
                        @if($senderObject)
                            {{ $senderObject->full_name }}
                        @endif
                    </td>
                    <td>
                        <?php $itemObject = $item->item; ?>
                        @if ($itemObject)
                            {{ $itemObject->title }}
                        @endif
                    </td>  
                    <td>
                        {{ date('d/m/Y H:i', strtotime($item->created_at)) }}
                    </td>  
                    <td>
                        <?php $reasonObject = $item->reporting_reason; ?>
                        @if ($reasonObject)
                            {{ $reasonObject->name }}
                        @endif
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <th>{{ trans('reporting::reportings.table.id') }}</th>
                <th>{{ trans('reporting::reportings.table.reported by') }}</th>
                <th>{{ trans('reporting::reportings.table.item title') }}</th>
                <th>{{ trans('reporting::reportings.table.time') }}</th>
                <th>{{ trans('reporting::reportings.table.message') }}</th>  
            </tr>
            </tfoot>
        </table>
        <!-- /.box-body -->
    </div>
</div>
