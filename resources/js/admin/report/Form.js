import AppForm from '../app-components/Form/AppForm';

Vue.component('report-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                report_time:  '' ,
                title:  '' ,
                content:  '' ,
                picture_url:  '' ,
                status:  '' ,
                citizen_id:  '' ,
                
            }
        }
    }

});