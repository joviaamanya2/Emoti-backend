- [ ] Locate where `App\Models\Appointments` is referenced
- [ ] Fix the import/model mismatch by switching to `App\Models\Appointment` (or renaming the model class/file)
- [ ] Update Filament resource to use the correct model class
- [ ] Run `php artisan optimize:clear` and `composer dump-autoload` (if needed)
- [ ] Verify app builds / Filament loads without the class-not-found error

