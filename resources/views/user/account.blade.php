@extends("general_base")
@section("title") My Account @endsection
@section("style")
<style>
.profile_img_view{
    width: 200px;
    height: 200px;
    border-radius: 5px 5px 0 0;
    cursor: pointer;
    object-fit: cover;
}
.modal_img_wrap{
    width: fit-content;
}
#img_preview{
    width: 200px;
    height: 200px;
    object-fit: cover;
}
.profile_img_container {
    position: relative;
    overflow: hidden;
    width: fit-content;
    margin: 0 auto;
}
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 25%;
    background: rgba(50, 50, 50, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;opacity: 0.8;
}
.overlay i {
    color: #e3e3e3;
    font-size: 2em;
}
#flag_icon{
    width: 20px;
}
.country_list_item:hover{
    background-color: #f79f1f;
    color: #ffffff;
    cursor: pointer;
}
</style>
@endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('user_account') }}" class="active">My Account</a>
	</div>
</div>
<!-- account -->
<div class="my_account_wrap section_padding_b">
	<div class="container">
		<div class="row">
			<!--  account sidebar  -->
			@include('partial.account_sidebar')
			<!-- account content -->
			<div class="col-lg-9">
				<div class="acprof_info_wrap shadow-sm mb-4">
          <div class="profile_img_container mb-3" data-bs-toggle="modal" data-bs-target="#profile_img_modal">
            <img src="{{ Storage::url( auth()->user()->avatar ) }}" class="img-fluid profile_img_view">
            <div class="overlay">
              <i class="fas fa-camera"></i>
            </div>
          </div>
          <h6 class="text-muted border-bottom mb-3 pb-1">Profile Details</h6>
          <form action="{{ route('user_account_update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="first_name" class="text-muted mb-1">First Name</label>
              <input type="text" name="first_name" id="first_name" value="{{ auth()->user()->first_name }}" required>
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="last_name" class="text-muted mb-1">Last Name</label>
              <input type="text" name="last_name" id="last_name" value="{{ auth()->user()->last_name }}" required>
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="email" class="text-muted mb-1">Email</label>
              <input type="text" name="email" id="email" value="{{ auth()->user()->email }}" required>
              @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <small class="text-danger">Your email address is unverified! <a href="javascript:void(0)" class="text-primary" onclick="submitResendMailForm()">Click here to re-send the verification email.</a></small>
                @if (session('status') === 'verification-link-sent')
                  <small class="text-success">A new verification link has been sent to your email address.</small>
                @endif
              @endif
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="phone" class="text-muted mb-1">Mobile Number</label>
              <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}" required>
            </div>
            <div class="col-12 single_billing_inp mb-3">
              <label for="company_name" class="text-muted mb-1">Company Name <small class="text-muted">(optional)</small></label>
              <input type="text" name="company_name" id="company_name" value="{{ auth()->user()->company_name }}">
            </div>
            <div class="col-12 mt-2 mb-3">
              <div class="border-top w-25 mx-auto"></div>
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="address_1" class="text-muted mb-1">Address</label>
              <input type="text" name="address" id="address" value="{{ auth()->user()->address }}" required>
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="city" class="text-muted mb-1">City</label>
              <input type="text" name="city" id="city" value="{{ auth()->user()->city }}" required>
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="state" class="text-muted mb-1">State/Region</label>
              <input type="text" name="state" id="state" value="{{ auth()->user()->state }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="text-muted mb-1">Country</label>
              <div class="d-flex justify-content-between">
                <span id="user_country_info"><img src="{{ asset('flags/'.auth()->user()->flag.'.svg') }}" id="flag_icon"> {{ auth()->user()->country }}</span>
                <button type="button" class="btn bg-light text-center border p-2" data-bs-toggle="modal" data-bs-target="#country_selector_modal"><i class="las la-flag text-dark p-0"></i></button>
              </div>
              <input type="hidden" name="flag" id="flag_field" value="{{ auth()->user()->flag }}">
              <input type="hidden" name="country" id="country_field" value="{{ auth()->user()->country }}">
            </div>
            <div class="col-md-6 single_billing_inp mb-3">
              <label for="zip_code" class="text-muted mb-1">Zip Code</label>
              <input type="tel" name="zip_code" id="zip_code" value="{{ auth()->user()->zip_code }}" required>
            </div>
            <div class="col-md-6">
              <label class="text-muted mb-1">Member Since</label>
              <div>{{ \Carbon\Carbon::parse(auth()->user()->joined_date)->format('M d, Y') }}</div>
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="default_btn rounded small">Save Changes</button>
            </div>
          </div>
          </form>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="acprof_info_wrap shadow-sm">
              <h5 class="text-danger border-bottom mb-3 pb-1"><i class="fas fa-user-times"></i> Close Account</h5>
              <small class="d-block">Note: Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please be aware that all your items, purchases, transactions and associated data will be permanently cleared.</small>
              <div>
                <button type="button" class="btn btn-danger btn-sm mt-2" id="account_dlt_confirm_btn">I Understand</button>
              </div>
              <div class="d-none" id="account_dlt_form">
                <form action="{{ route('user_account_delete') }}" method="POST">
                  @csrf
                  @method('delete')
                  <div class="single_billing_inp">
                    <label for="password" class="text-dark mb-1">Your Password</label>
                    <input type="password" name="password" id="password" required>
                  </div>
                  <div class="single_billing_inp">
                    <label for="verify" class="text-dark mb-1">To verify, type <i class="text-danger">confirm</i> below</label>
                    <input type="text" name="verify" id="verify" required>
                  </div>
                  <button type="submit" class="btn btn-outline-danger mt-3" id="confirmBtn" disabled>Yes, I Confirm</button>
                </form>
              </div>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>
<form action="{{ route('verification.send') }}" method="POST" id="resendMailForm" style="display: none;">
@csrf
</form>
<div class="modal fade" id="profile_img_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-muted mb-0">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user_account_update_img') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body bg-light">
        <div class="text-center border rounded modal_img_wrap p-1 mx-auto">
            <img src="{{ Storage::url( auth()->user()->avatar ) }}" class="img-fluid rounded" id="img_preview">
        </div>
        <div class="text-center mt-2">
            <input type="file" name="avatar" onchange="previewImage(event)" accept="image/png, image/jpeg, image/jpg">
        </div>
      </div>
      <input type="hidden" name="selected_avatar" id="selected_avatar" value="">
      <div class="modal-footer d-flex justify-content-between p-1">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success btn-sm">Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="country_selector_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Select Your Country</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
        <input type="text" id="country_search" class="form-control mb-2" placeholder="Search for your country">
        <ul class="list-group" id="country_list">
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
function previewImage(event){
    let input = event.target;
    let preview = document.getElementById('img_preview');
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
    preview.style.maxWidth = '200px';
    preview.style.maxHeight = '200px';
}
function submitResendMailForm(){
  document.getElementById('resendMailForm').submit();
}
const countryData = {
    "af": "Afghanistan", "al": "Albania", "dz": "Algeria", "as": "American Samoa", "ad": "Andorra", "ao": "Angola", "ai": "Anguilla", "aq": "Antarctica", "ag": "Antigua and Barbuda", "ar": "Argentina", "am": "Armenia", "aw": "Aruba", "au": "Australia", "at": "Austria", "az": "Azerbaijan", "bs": "Bahamas", "bh": "Bahrain", "bd": "Bangladesh", "bb": "Barbados", "by": "Belarus", "be": "Belgium", "bz": "Belize", "bj": "Benin", "bm": "Bermuda", "bt": "Bhutan", "bo": "Bolivia", "bq": "Bonaire, Sint Eustatius and Saba", "ba": "Bosnia and Herzegovina", "bw": "Botswana", "bv": "Bouvet Island", "br": "Brazil", "io": "British Indian Ocean Territory", "bn": "Brunei Darussalam", "bg": "Bulgaria", "bf": "Burkina Faso", "bi": "Burundi", "kh": "Cambodia", "cm": "Cameroon", "ca": "Canada", "cv": "Cabo Verde", "ky": "Cayman Islands", "cf": "Central African Republic", "td": "Chad", "cl": "Chile", "cn": "China", "cx": "Christmas Island", "cc": "Cocos (Keeling) Islands", "co": "Colombia", "km": "Comoros", "cg": "Congo", "cd": "Congo, Democratic Republic of the", "ck": "Cook Islands", "cr": "Costa Rica", "hr": "Croatia", "cu": "Cuba", "cw": "Curaçao", "cy": "Cyprus", "cz": "Czech Republic", "dk": "Denmark", "dj": "Djibouti", "dm": "Dominica", "do": "Dominican Republic", "ec": "Ecuador", "eg": "Egypt", "sv": "El Salvador", "gq": "Equatorial Guinea", "er": "Eritrea", "ee": "Estonia", "et": "Ethiopia", "eu": "European Union", "fk": "Falkland Islands (Malvinas)", "fo": "Faroe Islands", "fj": "Fiji", "fi": "Finland", "fr": "France", "gf": "French Guiana", "pf": "French Polynesia", "tf": "French Southern Territories", "ga": "Gabon", "gm": "Gambia", "ge": "Georgia", "de": "Germany", "gh": "Ghana", "gi": "Gibraltar", "gr": "Greece", "gl": "Greenland", "gd": "Grenada", "gp": "Guadeloupe", "gu": "Guam", "gt": "Guatemala", "gg": "Guernsey", "gn": "Guinea", "gw": "Guinea-Bissau", "gy": "Guyana", "ht": "Haiti", "hm": "Heard Island and McDonald Islands", "va": "Holy See (Vatican City State)", "hn": "Honduras", "hk": "Hong Kong", "hu": "Hungary", "is": "Iceland", "in": "India", "id": "Indonesia", "ir": "Iran, Islamic Republic of", "iq": "Iraq", "ie": "Ireland", "il": "Israel (Palestinian Territory)", "im": "Isle of Man", "it": "Italy", "jm": "Jamaica", "jp": "Japan", "je": "Jersey", "jo": "Jordan", "kz": "Kazakhstan", "ke": "Kenya", "ki": "Kiribati", "kp": "Korea, Democratic People's Republic of", "kr": "Korea, Republic of", "xk": "Kosovo", "kw": "Kuwait", "kg": "Kyrgyzstan", "la": "Lao People's Democratic Republic", "lv": "Latvia", "lb": "Lebanon", "ls": "Lesotho", "lr": "Liberia", "ly": "Libya", "li": "Liechtenstein", "lt": "Lithuania", "lu": "Luxembourg", "mo": "Macao", "mg": "Madagascar", "mw": "Malawi", "my": "Malaysia", "mv": "Maldives", "ml": "Mali", "mt": "Malta", "mh": "Marshall Islands", "mq": "Martinique", "mr": "Mauritania", "mu": "Mauritius", "yt": "Mayotte", "mx": "Mexico", "fm": "Micronesia, Federated States of", "md": "Moldova, Republic of", "mc": "Monaco", "mn": "Mongolia", "me": "Montenegro", "ms": "Montserrat", "ma": "Morocco", "mz": "Mozambique", "mm": "Myanmar", "na": "Namibia", "nr": "Nauru", "np": "Nepal", "nl": "Netherlands", "nc": "New Caledonia", "nz": "New Zealand", "ni": "Nicaragua", "ne": "Niger", "ng": "Nigeria", "nu": "Niue", "nf": "Norfolk Island", "mp": "Northern Mariana Islands", "no": "Norway", "om": "Oman", "pk": "Pakistan", "pw": "Palau", "ps": "Palestine", "pa": "Panama", "pg": "Papua New Guinea", "py": "Paraguay", "pe": "Peru", "ph": "Philippines", "pn": "Pitcairn", "pl": "Poland", "pt": "Portugal", "pr": "Puerto Rico", "qa": "Qatar", "re": "Réunion", "ro": "Romania", "ru": "Russian Federation", "rw": "Rwanda", "sh": "Saint Helena, Ascension and Tristan da Cunha", "kn": "Saint Kitts and Nevis", "lc": "Saint Lucia", "mf": "Saint Martin (French part)", "pm": "Saint Pierre and Miquelon", "vc": "Saint Vincent and the Grenadines", "ws": "Samoa", "sm": "San Marino", "st": "Sao Tome and Principe", "sa": "Saudi Arabia", "sn": "Senegal", "rs": "Serbia", "sc": "Seychelles", "sl": "Sierra Leone", "sg": "Singapore", "sx": "Sint Maarten (Dutch part)", "sk": "Slovakia", "si": "Slovenia", "sb": "Solomon Islands", "so": "Somalia", "za": "South Africa", "gs": "South Georgia and the South Sandwich Islands", "ss": "South Sudan", "es": "Spain", "lk": "Sri Lanka", "sd": "Sudan", "sr": "Suriname", "sj": "Svalbard and Jan Mayen", "se": "Sweden", "ch": "Switzerland", "sy": "Syrian Arab Republic", "tw": "Taiwan, Province of China", "tj": "Tajikistan", "tz": "Tanzania, United Republic of", "th": "Thailand", "tl": "Timor-Leste", "tg": "Togo", "tk": "Tokelau", "to": "Tonga", "tt": "Trinidad and Tobago", "tn": "Tunisia", "tr": "Turkiye", "tm": "Turkmenistan", "tc": "Turks and Caicos Islands", "tv": "Tuvalu", "ug": "Uganda", "ua": "Ukraine", "ae": "United Arab Emirates", "gb": "United Kingdom", "us": "United States", "um": "United States Minor Outlying Islands", "un": "United Nations", "uy": "Uruguay", "uz": "Uzbekistan", "vu": "Vanuatu", "ve": "Venezuela, Bolivarian Republic of", "vn": "Viet Nam", "vg": "Virgin Islands, British", "vi": "Virgin Islands, U.S.", "wf": "Wallis and Futuna", "eh": "Western Sahara", "ye": "Yemen", "zm": "Zambia", "zw": "Zimbabwe"
};
function populateCountryList() {
  const modalBody = document.querySelector("#country_selector_modal .modal-body");
  const searchInput = modalBody.querySelector("#country_search");
  const countryList = modalBody.querySelector("#country_list");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();
    const matchedCountries = Object.entries(countryData)
      .filter(([code, name]) => name.toLowerCase().includes(searchTerm))
      .slice(0, 5);

    renderCountryList(matchedCountries);
  });

  renderCountryList(Object.entries(countryData).slice(0, 5));
}
function renderCountryList(countryListData) {
  const listContainer = document.querySelector("#country_list");
  listContainer.innerHTML = "";

  for (const [countryCode, countryName] of countryListData) {
    const listItem = document.createElement("li");
    listItem.classList.add("list-group-item");
    listItem.classList.add("country_list_item");
    listItem.innerHTML = `<img src="{{ asset('flags') }}/${countryCode}.svg" id="flag_icon"> ${countryName}`;
    listItem.addEventListener('click', function () {
      document.getElementById('country_field').value = countryName;
      document.getElementById('flag_field').value = countryCode;
      document.getElementById('user_country_info').innerHTML = `<img src="{{ asset('flags') }}/${countryCode}.svg" id="flag_icon"> ${countryName}`;
      $('#country_selector_modal').modal('hide');
    });
    listContainer.appendChild(listItem);
  }
}
$('#country_selector_modal').on('shown.bs.modal', function () {
  populateCountryList();
  $("#country_search").focus();
});
$("#account_dlt_confirm_btn").click(function(){
    $(this).addClass("d-none");
    $("#account_dlt_form").removeClass("d-none");
    $("#account_dlt_msg").addClass("border-bottom-0");
});
$('#password, #verify').on('input', function(){
    let password = $('#password').val();
    let verify = $('#verify').val();
    let confirmBtn = $('#confirmBtn');

    if(password.length > 0 && verify === 'confirm'){
        confirmBtn.prop('disabled', false);
    }else{
        confirmBtn.prop('disabled', true);
    }
});
</script>
@endsection