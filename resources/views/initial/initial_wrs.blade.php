@extends('layouts.auth')


@section('content')

<div class="row justify-content-center">
    {{-- <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5 text-center p-0 mt-3 mb-2"> --}}
        <div class="card animated--fade-in px-0 pt-0 pb-0 mt-3 mb-3">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-info">Water Refilling Station (Initial) </h2>
            </div>
            {{-- <h2 id="heading">Water Refilling Station (Initial)</h2> --}}
            
            {{-- <p>Fill all form field to go to next step</p> --}}

            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active" id="account"><strong>Facility Information</strong></li>
                    <li id="personal"><strong>Application</strong></li>
                    <li id="payment"><strong>Attachment</strong></li>
                    {{-- <li id="confirm"><strong>Finish</strong></li> --}}
                </ul>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <br>
                <!-- fieldsets -->
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Facility Information:</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 1 - 3</h2>
                            </div>
                        </div>
                        <label class="fieldlabels">Email:</label>
                        <input type="email" name="email" placeholder="Official Email..."/>
                        <label class="fieldlabels">ADDRESS (Building No., Street, City/Municipality, Province)</label>
                        <input type="text" name="address" placeholder="Address..."/>
                        <label class="fieldlabels">NAME OF WATER REFILLING STATION:</label>
                        <input type="text" name="uname" placeholder=""/>
                        <label class="fieldlabels">LOCATION OF WATER REFILLING STATION (No., Street, City/Municipality, Province)</label>
                        <input type="text" name="uname" placeholder="UserName..."/>
                        <label class="fieldlabels">NAME OF OWNER/OPERATOR</label>
                        <input type="text" name="uname" placeholder="UserName"/>
                        <label class="fieldlabels">AREA TO BE SERVED:</label>
                        <input type="text" name="uname" placeholder="UserName"/>
                        <label class="fieldlabels">TYPE OF WATER SOURCE:</label>
                        <input type="text" name="uname" placeholder="UserName"/>
                        <label class="fieldlabels">Username: *</label>
                        <input type="text" name="uname" placeholder="UserName"/>
                        <label class="fieldlabels">Password: *</label>
                        <input type="password" name="pwd" placeholder="Password"/>
                        <label class="fieldlabels">Confirm Password: *</label>
                        <input type="password" name="cpwd" placeholder="Confirm Password"/>
                    </div>
                    <input type="button" name="next" class="next action-button" value="Next"/>
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Application</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 2 - 3</h2>
                            </div>
                        </div>
                        <label class="fieldlabels">First Name: *</label>
                        <input type="text" name="fname" placeholder="First Name"/>
                        <label class="fieldlabels">Last Name: *</label>
                        <input type="text" name="lname" placeholder="Last Name"/>
                        <label class="fieldlabels">Contact No.: *</label>
                        <input type="text" name="phno" placeholder="Contact No."/>
                        <label class="fieldlabels">Alternate Contact No.: *</label>
                        <input type="text" name="phno_2" placeholder="Alternate Contact No."/>
                    </div>
                    <input type="button" name="next" class="next action-button" value="Next"/>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Image Upload:</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 3 - 3</h2>
                            </div>
                        </div>
                        <label class="fieldlabels">Upload Your Photo:</label>
                        <input type="file" name="pic" accept="image/*">
                        <label class="fieldlabels">Upload Signature Photo:</label>
                        <input type="file" name="pic" accept="image/*">
                    </div>
                    <input type="button" name="next" class="next action-button" value="Submit"/>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                </fieldset>
                {{-- <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Finish:</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 4 - 4</h2>
                            </div>
                        </div>
                        <br><br>
                        <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <img src="https://i.imgur.com/GwStPmg.png" class="fit-image">
                            </div>
                        </div>
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-7 text-center">
                                <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                            </div>
                        </div>
                    </div>
                </fieldset> --}}
            </form>
        </div>
    {{-- </div> --}}
</div>
@endsection