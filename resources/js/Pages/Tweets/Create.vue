<template>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="tweetStore">
                <textarea v-model="content" placeholder="What do you wanna tweet ?"
                    class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none"></textarea>
                <span class="my-5 text-red-500" v-if="$page.props.errors.content">
                    {{$page.props.errors.content}}
                </span>
                <div class="flex items-center space-x-4 justify-end mt-3">
                    <p :class="{'text-red-500':remainingChars < 0}" class="text-sm text-gray-400 font-thin">{{remainingChars}} characters remaining</p>
                    <button-vue :disabled="!canSubmit" class="bg-blue-500 hover:bg-blue-800 rounded-full font-extrabold">Tweet</button-vue>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import ButtonVue from '@/Jetstream/Button'
    export default {

        components : {
                ButtonVue
        },

        data(){
            return {
                content: '',
                limit: 255,
            }
        },

        methods: {
            tweetStore(){
                this.$inertia.post('tweets',{content:this.content},{preserveState:false})
            }
        },
        
        computed: {
            /**
            * Checking the number of characters left for the user to write and showing it dynamically.
             */
            remainingChars(){
                return this.limit - this.content.length;
            },

            /**
            * Verify that the tweet correspond to the limit of characters all along the typing entry of the user.
             */
            canSubmit(){
                return this.content.length && this.remainingChars >= 0
            }
        }
    }

</script>

<style scoped>
    button:disabled{
        opacity: 50%;
        cursor:not-allowed;
    }
</style>