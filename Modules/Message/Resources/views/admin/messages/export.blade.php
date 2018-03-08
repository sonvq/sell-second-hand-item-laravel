<html>
    <head>
        <title>
            {{ trans('message::messages.title.chat export sheet name') }}
        </title>
    </head>
    <body>
        <div class="panel-body">
            <table class="table table-striped table-condensed table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('message::messages.chat.id') }}</th>
                        <th>{{ trans('message::messages.chat.message id') }}</th>
                        <th>{{ trans('message::messages.chat.sender username') }}</th>
                        <th>{{ trans('message::messages.chat.sender fullname') }}</th>
                        <th>{{ trans('message::messages.chat.message content') }}</th>
                        <th>{{ trans('message::messages.chat.send time') }}</th>
                        <th>{{ trans('message::messages.chat.message type') }}</th>
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
                                    {{ $item->message_id }}
                                </td>
                                <td>
                                    @if ($item->sender)
                                        {{ $item->sender->username }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->sender)
                                        {{ $item->sender->full_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->message_content }}
                                </td>
                                <td>
                                    {{ date('d/m/Y H:i', strtotime($item->sent_time)) }}
                                </td>
                                <td>
                                    @if ($item->message_type == 'text')
                                        Text
                                    @else
                                        Image
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