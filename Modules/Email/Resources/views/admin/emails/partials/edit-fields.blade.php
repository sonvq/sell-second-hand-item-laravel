<div class="box-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type',  trans('email::emails.table.type') ) !!}
                {!! Form::select('type', ['change_password' => 'Change Password',
                                          'forgot_password' => 'Forgot Password',
                                          'notification_email' => 'Notification Email',
                                          'promote_email' => 'Promote Email',
                                          'welcome_email' => 'Welcome Email'],         $email->type, ['class' => 'form-control']) !!}

                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class='form-group{{ $errors->has("subject") ? ' has-error' : '' }}'>
                {!! Form::label("subject", trans('email::emails.table.subject')) !!}
                {!! Form::text("subject", $email->subject, ['class' => 'form-control ', 'data-slug' => 'source']) !!}
                {!! $errors->first("subject", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='form-group{{ $errors->has("content") ? ' has-error' : '' }}'>
                {!! Form::label("content", trans('email::emails.table.content')) !!}
                {!! Form::textarea("content", $email->content, ['id' => 'contentEmail', 'class' => 'form-control ', 'data-slug' => 'source']) !!}
                {!! $errors->first("content", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                {!! Form::label('status',  trans('email::emails.table.status') ) !!}
                {!! Form::select('status', ['publish' => 'Publish',
                                          'draft' => 'Draft'],         $email->status, ['class' => 'form-control']) !!}

                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@push('js-stack')
<script>
    // Replace the <textarea id="contentEmail"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'contentEmail' );
</script>
@endpush
