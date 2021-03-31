<template>
    <div>        
        <template v-if="reply">
            <comment-reply :comment="reply" />
        </template>

        <template v-else>            
        
            <h5 class="mt-4 mb-2" v-if="meta.total == 0">No Comment</h5>
            <h5 class="mt-4 mb-2" v-else>{{ meta.total }} {{ pluralize('comment', meta.total) }}</h5>
            <new-comment 
                :endpoint="endpoint"  v-if="alouser.authenticated"           
            />
            
            <template v-if="comments.length">
                <ul class="list-unstyled">
                   <comment v-for="comment in comments" :key="comment.id" :comment="comment" />     
                </ul>
            </template>
            <p v-else>No comments to display.</p>

            <a href="#" 
                class="btn btn-light btn-block"
                @click.prevent="loadMore"
                v-if="meta.current_page < meta.last_page"
            >Show More</a>

        </template>
    </div>
</template>

<script>
    import Comment from './Comment'
    import NewComment from './NewComment'
    import CommentReply from './CommentReply'
    import bus from '../../bus'
    import axios from 'axios'


    export default {
        data () {
            return {
                comments: [],
                meta: {},
                reply: null
            }
        },
        props: {
            endpoint: {
                required: true,
                type: String
            }
        },
        components: {
            NewComment,
            Comment,
            CommentReply
        },
        methods: {
            async prependComment (comment) {
                this.comments.unshift(comment)

                await this.fetchMeta()

                if(this.meta.current_page < this.meta.last_page){
                    this.comments.pop()
                }
            },

            async fetchMeta () {
                let comments = await axios.get(`${this.endpoint}?page=${this.meta.current_page}`)
                this.meta = comments.data.meta
            }, 

            async loadComments(page = 1) {
                let comments = await axios.get(`${this.endpoint}?page={page}`)

                this.comments = comments.data.data

                this.meta = comments.data.meta
            }, 

            async loadMore() {
                let comments = await axios.get(`${this.endpoint}?page=${this.meta.current_page + 1}`)

                this.comments.push(...comments.data.data)
                this.meta = comments.data.meta
            },

            setReplying (comment) {
                this.reply = comment
            },

            appendReply ({ comment, reply }) {
                _.find(this.comments, { id: comment.id }).children.push(reply)
            }

        },
        mounted () {
            this.loadComments()
            bus.$on('comment:stored', this.prependComment)
            bus.$on('comment:reply', this.setReplying)
            bus.$on('comment:replied', this.appendReply)
            bus.$on('comment:reply-cancel', () => this.reply = null )
        }
    }
</script>