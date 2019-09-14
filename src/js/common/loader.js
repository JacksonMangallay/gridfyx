import Vue from 'vue';

export default new Vue({
    el: '.loader',
    data: function(){
        return {
            content: '',
            loaded: false
        }
    },
    mounted: function(){

        setTimeout(() => {
            
            this.loaded = true;
            document.querySelector('.app-content').classList.add('loaded');
            
            setTimeout(() => {
                document.body.classList.remove('loading');
            }, 300);

        }, 500)

    }
})