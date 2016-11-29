$(document).ready(function(){

//----------------------------EMAIL PLACEHOLDER CHANGE------------------------------------
/*========================================================================================
==========================================================================================
==========================================================================================*/
    var placeHolder = ['example@mail.com','example@mail.co','example@mail.c','example@mail.',
                       'example@mail','example@mai','example@ma','example@m',
                       'example@','example','exampl','examp',
                       'exam','exa','ex','e','','ex','exa','exam',
                       'examp','exampl','example','example@','example@m',
                       'example@ma','example@mai','example@mail','example@mail.',
                       'example@mail.c','example@mail.co','example@mail.com'];
    var n=0;
    var loopLength=placeHolder.length;

    setInterval(function(){
       if(n<loopLength){
          var newPlaceholder = placeHolder[n];
          n++;
          $('.email-placeholder-change').attr('placeholder',newPlaceholder);
       } else {
          $('.email-placeholder-change').attr('placeholder',placeHolder[0]);
          n=0;
       }
    },100);


//----------------------------EMAIL PLACEHOLDER CHANGE END--------------------------------
/*========================================================================================
==========================================================================================
==========================================================================================*/


// ----------------------------For Register-----------------------------------------------
$('#operator-numbers').change(function(){
 var op_num = $(this).val();
$('#operator').attr('value',op_num);
return false;
});

$('#CitySelectOption').change(function(){
 var city_option = $(this).val();
$('#city').attr('value',city_option);
return false;
});
//-----------------------------For Register End -------------------------------------------

//-----------------------------For destek button  -------------------------------------------
$(".destek-ol-message").hide();
    $(".destek-ol-button").click(function(){
        $(".destek-ol-message").slideToggle();

    });
 //-----------------------------For destek button  End-------------------------------------------


//------------------------------For searchBoxDrag -----------------------------------------
$('#searchBoxDrag').draggable({
          containment: '#InfoMap'
      });
});
//------------------------------For searchBoxDrag End -------------------------------------


//------------------------------For Login Ajax --------------------------------------------
$('#SubmitLogin').submit(function(event) {
  $('#EmailGroup').removeClass('has-error')
  $('#PasswordGroup').removeClass('has-error')
  $('#EmailError').html('');
  $('#PasswordError').html('');
  event.preventDefault();
  var Login = $.ajax({
    url: '/login',
    type: 'POST',
    dataType: 'json',
    headers:{
    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
  },
    data: {
      email: $('#email').val(),
      password: $('#pass').val()
    },
    success: function(data){

    },
    beforeSend:function(){
      $('#submit').val('Loading..');
    },
    complete:function(){
      $('#submit').val('Daxil ol');
    },
    error:function(data){
      var errors = data.responseJSON;
      if (errors['email'] == 'The email field is required.') {
        var ForEmailError = 'Emaili boş buraxmayın';
        $('#EmailGroup').addClass('has-error')
      }
      if (errors['password'] == 'The password field is required.') {
        var ForPasswordError = 'Şifreni boş buraxmayın';
        $('#PasswordGroup').addClass('has-error')
      }
      $('#EmailError').html(ForEmailError);
      $('#PasswordError').html(ForPasswordError);
    }
  })
  Login.done(function(data) {
    location.reload();
  })
});
//------------------------------For Login Ajax End ----------------------------------------

// ----------------------------For Map in destek_add and istek_add pages-----------------------------------------------
function initAutocomplete() {

  var map = new google.maps.Map(document.getElementById('map'), {
    center: {  lat: 40.100,lng: 47.500},
    zoom: 7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoomControl:false,
    streetViewControl:false,
    mapTypeControl:false,
    overViewMapControl:false
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('adress');
  var searchBox = new google.maps.places.SearchBox(input);
  // map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        animation: google.maps.Animation.DROP,
        position: place.geometry.location
      })
    );
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
        console.log(place.vicinity)
          document.getElementById('lat').value = place.geometry.location.lat();
          document.getElementById('lng').value = place.geometry.location.lng();


      } else {
        bounds.extend(place.geometry.location);
          console.log(place.formatted_address)
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();

      }
    });
    map.fitBounds(bounds);
  });
}

//-----------------------------For Map End -------------------------------------------
