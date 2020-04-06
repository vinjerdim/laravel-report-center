import AppForm from '../app-components/Form/AppForm';

Vue.component('officer-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                username:  '' ,
                password:  '' ,
                phone:  '' ,
                
            }
        }
    }

});