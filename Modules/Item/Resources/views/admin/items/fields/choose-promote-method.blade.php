<div class="form-group">
    <label for="{{ $settingName }}">{{ trans($moduleInfo['description']) }}</label>
    <select class="form-control" name="{{ $settingName }}" id="{{ $settingName }}">
        <option value="social_promote" {{ isset($dbSettings[$settingName]) && $dbSettings[$settingName]->plainValue == "social_promote" ? 'selected' : '' }}>
            Share in Facebook & Promote
        </option>
        <option value="listing_promote" {{ isset($dbSettings[$settingName]) && $dbSettings[$settingName]->plainValue == "listing_promote" ? 'selected' : '' }}>
            Promote on top of the list
        </option>
    </select>    
</div>
