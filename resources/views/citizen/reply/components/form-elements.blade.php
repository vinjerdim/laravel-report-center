<div class="form-group row align-items-center" :class="{'has-danger': errors.has('reply_time'), 'has-success': fields.reply_time && fields.reply_time.valid }">
    <label for="reply_time" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reply.columns.reply_time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.reply_time" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('reply_time'), 'form-control-success': fields.reply_time && fields.reply_time.valid}" id="reply_time" name="reply_time" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('reply_time')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('reply_time') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('content'), 'has-success': fields.content && fields.content.valid }">
    <label for="content" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reply.columns.content') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.content" v-validate="'required'" id="content" name="content" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('content')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('content') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('officer_id'), 'has-success': fields.officer_id && fields.officer_id.valid }">
    <label for="officer_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reply.columns.officer_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.officer_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('officer_id'), 'form-control-success': fields.officer_id && fields.officer_id.valid}" id="officer_id" name="officer_id" placeholder="{{ trans('admin.reply.columns.officer_id') }}">
        <div v-if="errors.has('officer_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('officer_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('report_id'), 'has-success': fields.report_id && fields.report_id.valid }">
    <label for="report_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reply.columns.report_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.report_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('report_id'), 'form-control-success': fields.report_id && fields.report_id.valid}" id="report_id" name="report_id" placeholder="{{ trans('admin.reply.columns.report_id') }}">
        <div v-if="errors.has('report_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('report_id') }}</div>
    </div>
</div>


