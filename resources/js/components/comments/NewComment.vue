<template>
    <div class="mb-5 mt-3">
        <a href="#"
            class="btn btn-primary btn-block"
            @click.prevent="active = true"
            v-if="!active"
            >Post a Comment</a>

            <template v-if="active">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <textarea name="body" class="form-control"  id="" rows="3" v-model="form.body" autofocus="autofocus" ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="#" class="btn btn-secondary" @click.prevent="active = false">Cancel</a>
                    </div>
                </form>
                
            </template>
    </div>
</template>

<script>
    import axios from 'axios'
    import bus from '../../bus'
    
    export default {
        data () {
            return {
                active: false,
                form: {
                    body: ''
                }
            }
        },
        props: {
            endpoint: {
                required: true,
                type: String
            }
        },
        methods: {
            async submit () {
                let comment = await axios.post(this.endpoint, this.form)

                bus.$emit('comment:stored', comment.data.data)

                this.active = false
                this.form.body = ''
            }
        }
    }
</script>