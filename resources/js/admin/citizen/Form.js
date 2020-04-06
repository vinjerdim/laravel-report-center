import AppForm from '../app-components/Form/AppForm';

Vue.component('citizen-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                username:  '' ,
                password:  '' ,
                email:  '' ,
                phone:  '' ,
                
            }
        }
    }

});