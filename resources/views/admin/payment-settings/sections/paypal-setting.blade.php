<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.paypal-setting.update', 1) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Paypal Status</label>
                    <select name="status" class="form-control">
                        <option {{ $paypalSetting->status === 1 ? 'selected' : '' }} value="1">Enable</option>
                        <option {{ $paypalSetting->status === 0 ? 'selected' : '' }} value="0">Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Account Mode</label>
                    <select name="mode" class="form-control">
                        <option {{ $paypalSetting->mode === 0 ? 'selected' : '' }} value="0">Sandbox</option>
                        <option {{ $paypalSetting->mode === 1 ? 'selected' : '' }} value="1">Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Country Name</label>
                    <select name="country_name" class="form-control select2">
                        <option value="">Select</option>
                        @foreach(config('settings.country_list') as $country)
                            <option
                                {{ $country === $paypalSetting->country_name ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Currency name</label>
                    <select name="currency_name" class="form-control select2">
                        <option value="">Select</option>
                        @foreach(config('settings.currency_list') as $key => $currency)
                            <option
                                {{$currency === $paypalSetting->currency_name ? 'selected' : '' }} value="{{ $currency }}">{{ $currency }}
                                - {{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Currency rate (Per USD)</label>
                    <input type="text" class="form-control" name="currency_rate"
                           value="{{ $paypalSetting->currency_rate }}">
                </div>

                <div class="form-group">
                    <label>Paypal Client ID</label>
                    <input type="text" class="form-control" name="client_id" value="{{ $paypalSetting->client_id }}">
                </div>

                <div class="form-group">
                    <label>Paypal Secret Key</label>
                    <input type="password" class="form-control" name="secret_key"
                           value="{{ $paypalSetting->secret_key }}">
                </div>

                <button class="btn btn-primary" type="submit">Update</button>

            </form>
        </div>
    </div>
</div>