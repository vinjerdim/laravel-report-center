import AppForm from '../app-components/Form/AppForm';

Vue.component('reply-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                reply_time:  '' ,
                content:  '' ,
                officer_id:  '' ,
                officer:  '' ,
                report_id:  '' ,

            }
        }
    }

});
