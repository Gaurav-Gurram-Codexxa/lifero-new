<div class="footer py-4 d-flex flex-lg-column position-sticky bottom-0">
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="text-muted">
            <span>All Rights Reserved</span>
            <span class="text-muted fw-bold me-1">&copy {{ date('Y') }}</span>
            <!--<a data-turbo="false" href="{{ url('/') }}" class="text-hover-primary">{{ getLoggedInUser()->hasRole('Super Admin') ? $superAdminSettingValue : getSettingValueByKey('app_name') }}</a>-->
            <a data-turbo="false" href="https://lifero.bizz-manager.com" class="text-hover-primary">Lifero</a>
        </div>
        <div class="text-muted order-2 order-md-1">
            <!--v{{ getCurrentVersion() }}-->
        </div>
    </div>
</div>
