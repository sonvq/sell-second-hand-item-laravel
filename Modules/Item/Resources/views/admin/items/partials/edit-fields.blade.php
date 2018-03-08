<div class="box-body">
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.id')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->id }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.title')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->title }}
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.category')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $category = $item->category; ?>
                @if ($category)
                    {{ $category->name }}
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.subcategory')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $subcategory = $item->subcategory; ?>
                @if ($subcategory)
                    {{ $subcategory->name }}
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.description')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->description }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.username')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $appuser = $item->appuser; ?>
                @if ($appuser)
                    {{ $appuser->username }}
                @endif
                
            </p>
        </div>
    </div>  
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.created date')}}</label>
        </div>
        <div class="col-md-10">
            <td>                                    
                {{ date('d/m/Y', strtotime($item->created_at)) }}
            </td>
        </div>
    </div>  
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.status')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                @if ($item->sell_status == 'selling')
                    Available
                @else 
                    Sold
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.original price')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->price_number }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.final price')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->discount_price_number }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.price currency')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ strtoupper($item->price_currency) }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.discount percent')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->discount_percent }} %
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.photos')}}</label>
        </div>
        <div class="col-md-10">
            <td>                                    
                <?php $photos = $item->gallery ?>
                <?php if (count($photos) > 0) : ?>
                    <?php foreach ($photos as $key => $singlePhoto) : ?>                                        
                        <a href="<?php echo $singlePhoto->large_url; ?>" data-loop="true" data-fancybox="images" data-caption="{{ $item->title }}">
                            <img class="img-gallery" src="<?php echo $singlePhoto->thumb_file_url; ?>" style="margin-bottom: 5px;" />
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    No photo provided
                <?php endif; ?>
                
            </td>
        </div>
    </div>
    
    
       
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.country')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $country = $item->country; ?>
                @if ($country)
                    {{ $country->name }}
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.city')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $city = $item->city; ?>
                @if ($city)
                    {{ $city->name }}
                @endif
            </p>
        </div>
    </div>                
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.featured')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                @if ($item->featured == 0)
                    No
                @else 
                    Yes
                @endif
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.promote method')}}</label>
        </div>
        <div class="col-md-10">
            <?php $arrayPromoteMethodConfig = config("asgard.item.config.promote_method", []); ?>
            <p>
                @if (count($arrayPromoteMethodConfig) > 0 && isset($arrayPromoteMethodConfig[$item->promote_method]))
                    {{ $arrayPromoteMethodConfig[$item->promote_method] }}
                @else 
                    Not Promoted
                @endif
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.promote package')}}</label>
        </div>
        <div class="col-md-10">
            <?php $promotePackage = $item->promote; ?>
            <p>
                @if ($promotePackage)
                    MMK {{ $promotePackage->price_amount }} for {{ $promotePackage->number_of_date_expired }} days                    
                @else 
                    Not Promoted
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.feature start date')}}</label>
        </div>
        <div class="col-md-10">            
            <p>
                @if($item->featured_end_date)
                    {{ date('d/m/Y H:i:s', strtotime($item->featured_start_date)) }}
                @else
                    Not Promoted
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.feature end date')}}</label>
        </div>
        <div class="col-md-10">            
            <p>
                @if($item->featured_end_date)
                    {{ date('d/m/Y H:i:s', strtotime($item->featured_end_date)) }}
                @else
                    Not Promoted
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.collection delivery')}}</label>
        </div>
        <div class="col-md-10">
            <?php $arrayCollectionDeliverConfig = config("asgard.item.config.collection_deliver", []); ?>
            <p>
                @if (count($arrayCollectionDeliverConfig) > 0 && isset($arrayCollectionDeliverConfig[$item->deliver]))
                    {{ $arrayCollectionDeliverConfig[$item->deliver] }}
                @else 
                    Not Provided
                @endif
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.item condition')}}</label>
        </div>
        <div class="col-md-10">
            <?php $arrayItemConditionConfig = config("asgard.item.config.item_condition", []); ?>
            <p>
                @if (count($arrayItemConditionConfig) > 0 && isset($arrayItemConditionConfig[$item->item_condition]))
                    {{ $arrayItemConditionConfig[$item->item_condition] }}
                @else 
                    Not Provided
                @endif
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.meetup location')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $item->meetup_location }}
            </p>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('item::items.form.map')}}</label>
        </div>
        <div class="col-md-10">
            @if (($item->latitude) && ($item->longitude))
                <div id="map"></div>
            @else
                Not provided
            @endif
        </div>        
    </div> 
                
</div>

@push('js-stack')
    <script src="{{ Module::asset('item:vendor/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDR-X6wzVoqX0si0BDwVm4PrtZTqH3fMWo" async defer></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            var map;  
            var myLatLng = {lat: {{ $item->latitude }}, lng: {{ $item->longitude }}};
            
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatLng,
                    zoom: 16
                });
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: '{{ $item->meetup_location }}'
                });
            } 

            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.item.item.index') ?>" }
                ]
            });
            
             $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            
            setTimeout(function(){
                initMap();
            }, 1000);                     
            
        });
    </script>  
    
@endpush
