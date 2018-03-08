<div class="form-group">
    <label for="{{ $settingName }}">{{ trans($moduleInfo['description']) }}</label>
    <input class="form-control" name="{{ $settingName }}" id="{{ $settingName }}" 
           required="required"
           min="0" 
           max="24" 
           type="number" 
           value="{{ isset($dbSettings[$settingName]) ? $dbSettings[$settingName]->plainValue : 24 }}" />
</div>
