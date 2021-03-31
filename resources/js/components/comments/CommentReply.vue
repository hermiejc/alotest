<template>
    <div>
        <h5 class="mb-3 mt-4">Replying to comment</h5>

        <comment :comment="comment" :links="false" />

        <form @submit.prevent="store" id="reply">
            <div class="form-group">
                <textarea 
                    name="body" 
                    id="body"  
                    rows="3" 
                    class="form-control"
                    autofocus="autofocus" 
                    v-model="form.body"
                ></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Reply</button>
                <a href="#" class="btn btn-secondary" @click.prevent="cancel">Cancel</a>
            </div>
        </form>
    </div>
</template>

<script>
    import Comment from './Comment'
    import bus from '../../bus'
    import axios from 'axios'
    import VueScrollTo from 'vue-scrollto'

    export default {
        data () {
            return {
                form: {
                    body: ''
                }
            }
        },
        props: {
            comment: {
                required: true,
                type: Object
            }
        },

        components: {
            Comment
        },

        methods: {
            async store () {
                let reply = await axios.post(`/comments/${this.comment.id}/replies`, this.form)

                //this.comment.children.push(reply.data.data)
                bus.$emit('comment:replied', {
                    comment: this.comment,
                    reply: reply.data.data
                })

                this.cancel();
            },
            cancel () {
                bus.$emit('comment:reply-cancel')
            }
        },

        mounted () {
            VueScrollTo.scrollTo('#reply', 500)
        }
    }
</script>