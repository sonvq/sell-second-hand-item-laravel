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
                        <th>{{ trans('item::items.table.id') }}</th>
                        <th>{{ trans('item::items.table.title') }}</th>
                        <th>{{ trans('item::items.table.category') }}</th>  
                        <th>{{ trans('item::items.table.subcategory') }}</th> 
                        <th width='200'>{{ trans('item::items.table.description') }}</th> 
                        <th>{{ trans('item::items.table.username') }}</th> 
                        <th>{{ trans('item::items.table.created date') }}</th>                                                                
                        <th>{{ trans('item::items.table.status') }}</th>   
                        <th>{{ trans('item::items.table.original price') }}</th>
                        <th>{{ trans('item::items.table.final price') }}</th> 
                        <th>{{ trans('item::items.table.featured') }}</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($items) && (count($items) > 0)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    @if ($item->category)
                                        {{ $item->category->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->subcategory)
                                        {{ $item->subcategory->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->description }}
                                </td>
                                <td>
                                    @if ($item->appuser)
                                        {{ $item->appuser->username }}
                                    @endif
                                </td>                                
                                <td>                                    
                                    {{ date('d/m/Y', strtotime($item->created_at)) }}
                                </td>
                                <td>
                                    @if ($item->sell_status == 'selling')
                                        Available
                                    @else 
                                        Sold
                                    @endif
                                </td>
                                <td>                                    
                                    {{ $item->price_number }}
                                </td>
                                <td>                                    
                                    {{ $item->discount_price_number }}
                                </td>  
                                <td>                                    
                                    <?php if ($item->featured == 0) : ?>
                                        No
                                    <?php else : ?>
                                        Yes
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </body>
</html>