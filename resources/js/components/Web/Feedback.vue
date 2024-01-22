<template>
<main>
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="account-title match-title">
                <h4>Feedback Listing</h4>
            </div>
            <div class="box1 mt-4">
                <span @click.prevent="addfeedbacks()">
                    <button class="btn btn-primary">
                        Add Feedback
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 main-b">
                <div class="row">
                    <div class="col-xl-12 col-md-12 ">
                        <div class="graph__wrapper-width pd">
                            <div class="table-container table-responsive p-4" style="overflow-x: auto;">

                                <div class="row">
                                    <div class="col-6">
                                        <div class="dataTables_length" id="table_length"><label>Show entries<select @change="getFeedback()" v-model="table_length" aria-controls="table" class="form-control entries">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="dataTables_length float-right" id="table_length"><label style="float: right;">Search: <input v-model="search_query" @keyup.enter="getFeedback()" class="form-control" type="text" placeholder="Search here" style="font-size: 16px;"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-rwd">
                                        <thead>
                                            <tr>
                                                <th class="text-center">User</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(feedback, index) in feedbacks.data" :key="index" v-if="dataCount > 0">
                                                <tr class="commentss">
                                                    <td style="background: #edf7f6;">{{ feedback.username }}</td>
                                                    <td>{{ feedback.title }}</td>
                                                    <td>{{ feedback.description }}</td>
                                                    <td>{{ feedback.category }}</td>
                                                    <td>
                                                        <a href="#" @click.prevent="addFields(feedback.id)">

                                                            <span title="Add Comment" style="font-size:large;color:blue">
                                                                <i class="fa fa-plus" aria-hidden="true" style="color:#0096FF;" name="add-outline">
                                                                </i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="comments-row">
                                                        <div v-for="(feedback2, index2) in feedback.comments" :key="index2" class="comment">
                                                            <div class="comment-header">
                                                                <strong>{{ feedback2.username }}</strong>
                                                            </div>
                                                            <div class="comment-content" v-html="feedback2.content"></div>
                                                            <div> {{ $moment(feedback2.created_at).format("YYYY.MM.DD hh:mm:ss A") }} </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td style="text-align: center;" colspan="5">No Data Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- </div> -->
                                </div>

                                    <nav aria-label="...">
                                        <ul class="pagination flex-wrap justify-content-start justify-content-md-end mt-3" v-if="dataCount > 0">
                                            <template v-for="link in feedbacks.links">
                                                <li :class="[(link.active) ? 'active' : '', (link.url == null) ? 'disabled' : '', 'page-feedback']" @click.prevent="getFeedback(link.url)" :data-label="link.label" style="cursor:pointer" aria-current="page">
                                                    <span class="page-link" v-html="link.label"></span>
                                                </li>

                                            </template>
                                        </ul>
                                        <ul v-else>
                                        </ul>
                                    </nav>

                            </div>
                        </div>
                    </div>
                    <!-- Add feedbacks -->
                    <div v-if="popup2 == true" class="overlay">
                        <div class="popup">
                            <h2>Add Feedback</h2>
                            <a class="close" href="#" @click.prevent="closePopup2()">&times;</a>
                            <div class="email-feild account-feild w-100">
                                <input type="text" name="title" v-model="state.title" required="" @keyup.enter="addfeedback()" placeholder="Enter Title">
                            </div>
                            <div v-if="v$.title.$error" style="text-align:center">
                                <b style="color:red;">
                                    {{ v$.title.$errors[0].$message }}
                                </b>
                            </div>

                            <div class="email-feild account-feild w-100">
                                <input type="text" name="description" v-model="state.description" required="" @keyup.enter="addfeedback()" placeholder="Enter Description">
                            </div>
                            <div v-if="v$.description.$error" style="text-align:center">
                                <b style="color:red;">
                                    {{ v$.description.$errors[0].$message }}
                                </b>
                            </div>

                            <div class="email-feild account-feild w-100">
                                <select name="type" class="selectOption" v-model="state.category" required="" @keyup.enter="addfeedback()">
                                    <option value="">Select Category</option>
                                    <option value="bug">Bug Report</option>
                                    <option value="feature">Feature Request</option>
                                    <option value="improvement">Improvement</option>
                                </select>
                            </div>
                            <div v-if="v$.category.$error" style="text-align:center">
                                <b style="color:red;">
                                    {{ v$.category.$errors[0].$message }}
                                </b>
                            </div>

                            <div class="pop-tos">
                                <div class="tos1"><a href="#" @click.prevent="closePopup2()">Cancel</a>
                                </div>
                                <div class="tos2">
                                    <a style="color:white" @click="addfeedback()">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Add Method Fields -->
                    <div id="popup1" v-if="popup3 == true" class="overlay">
                        <div class="popup">
                            <h2>Add Payment Fields</h2>
                            <a class="close" href="#" @click.prevent="closeCommentpop()">&times;</a>
                            <label for="content">Username</label>
                            <div class="email-feild account-feild w-100" style="padding: 0px 0px;">
                                <input type="text" name="username" v-model="username" required="" @keyup.enter="addComment()" placeholder="Enter Field Name">
                            </div>

                            <label for="content">Content</label>
                            <div class="form-field">
                                <div class="input_select" style="padding-top: 10px;">
                                    <QuillEditor ref="quillEditorRef" theme="snow" name="content" :modelValue="content" @update:modelValue="onEditorChange" @ready="onEditorReady" style="width: 100%; min-height: 100px;" />

                                </div>
                            </div>

                            <div class="pop-tos">
                                <div class="tos1"><a href="#" @click.prevent="closeCommentpop()">Cancel</a>
                                </div>
                                <div class="tos2">
                                    <a style="color:white" @click="addComment()">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="loader-wrapper" style="display: flex;">
        <span class="loader"><span class="loader-inner"></span></span>
    </div>
</main>
</template>

<script>
import axios from 'axios';
import useVuelidate from "@vuelidate/core";
import {
    reactive,
    ref,
    watch,
    onUpdated,
    onMounted
} from 'vue';

import {
    required,
    helpers,
} from "@vuelidate/validators";
import {
    useRouter,
    useRoute
} from 'vue-router';
import Select2 from 'vue3-select2-component';
import {
    QuillEditor
} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: 'Feedback',
    components: {
        Select2,
        QuillEditor
    },
    setup() {
        const table_length = ref(10)
        const dataCount = ref(0)
        const popup2 = ref(false)
        const popup3 = ref(false)
        const search_query = ref('')
        const feedbacks = ref([])
        const $externalResults = ref({})

        const quillEditorRef = ref(null);
        const editorData = ref('');
        const username = ref('');
        const content = ref('');

        const state = reactive({
            title: '',
            description: '',
            category: 'bug'
        })
        const pid = ref(0)
        const rules = {
            title: {
                required: helpers.withMessage('Title must be required', required),
            },
            description: {
                required: helpers.withMessage('Description must be required', required),
            },
            category: {
                required: helpers.withMessage('Category must be required', required),
            }
        }
        const v$ = useVuelidate(rules, state, {
            $externalResults
        })

        onMounted(() => {
            getFeedback()
        })

        watch(search_query, (newVal, oldVal) => {
            if (search_query.value == '')
                getFeedback()
        })

        const getFeedback = async (url = 'getFeedback?page=1') => {
            await axios.get(url + '&pageSize=' + table_length.value + '&search_query=' + search_query.value)
                .then((response) => {
                    feedbacks.value = response.data.record;
                    dataCount.value = response.data.record.total
                    onEditorReady()
                })
        }

        const addfeedbacks = () => {
            state.title = ''
            state.description = ''
            state.category = ''
            popup2.value = true;
        }

        const addFields = (v) => {
            state.username = '';
            state.type = 'text';
            pid.value = v,
                popup3.value = true;
        }

        const closePopup2 = () => {
            v$.value.$clearExternalResults()
            popup2.value = false;
        }

        const closeCommentpop = () => {
            v$.value.$clearExternalResults()
            popup3.value = false;
        }

        // Add feedbacks
        const addfeedback = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                await axios.post('addfeedback', state).then((response) => {
                    if (response.data.success == true) {

                        getFeedback()
                        closePopup2()
                        Toast.fire({
                            text: response.data.message,
                            timer: 2000,
                            icon: 'success',
                            position: 'top-end',

                        });
                    } else {
                        Toast.fire({
                            text: response.data.message,
                            timer: 5000,
                            icon: "error",
                            position: "top-end",
                        });
                        // $externalResults.value = response.data.message
                    }
                })

            }
        }

        // Add Method Fields
        const addfeedbackField = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                await axios.post('add-method-field/' + pid.value, state).then((response) => {
                    if (response.data.success == true) {
                        getFeedback()
                        closeCommentpop()
                        Toast.fire({
                            text: response.data.message,
                            timer: 2000,
                            icon: 'success',
                            position: 'top-end',

                        });
                    } else {
                        $externalResults.value = response.data.message
                    }
                })

            }
        }

        const onEditorReady = () => {
            const quillEditorContainer = document.querySelector('.ql-blank');
            if (quillEditorContainer) {
                quillEditorContainer.innerHTML = editorData.value;
            }
        };

        const onEditorChange = (content) => {
            content.value = content;
        };

        const addComment = async () => {
            const data = {
                content: quillEditorRef.value.getHTML(),
                username: username.value,
            };

            const response = await axios.post('add-comment/' + pid.value, data);
            if (response.data.status === true) {
                getFeedback()
                closeCommentpop()
                Toast.fire({
                    text: response.data.message,
                    timer: 3000,
                    icon: 'success',
                    position: 'top-end',
                });
            } else {
                // Error message handling
                Toast.fire({
                    text: response.data.message,
                    timer: 3000,
                    icon: 'error',
                    position: 'top-end',
                });
            }

        };

        return {
            v$,
            state,
            popup2,
            popup3,
            feedbacks,
            dataCount,
            table_length,
            search_query,
            getFeedback,
            addfeedbacks,
            addFields,
            addfeedback,
            addfeedbackField,
            closePopup2,
            closeCommentpop,
            quillEditorRef,
            editorData,
            username,
            content,
            onEditorReady,
            onEditorChange,
            addComment,
        }
    }
}
</script>

<style scoped>
.overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    visibility: visible;
    opacity: 1;
    overflow: auto !important;
    z-index: 1039 !important;
}

.arrow {
    width: 35px;
    height: 35px;
    background: #f7ecec;
    border-radius: 50px;
    display: flex;
    margin: auto;
    align-feedbacks: center;
    justify-content: center;
}

.selectOption {
    width: 100%;
    padding: 10px;
    border-radius: 15px;
    outline: none;
    border: 1px solid rgb(241, 238, 238);
}

.pop-tos {
    display: flex;
    align-feedbacks: center;
    justify-content: center;
    padding-top: 20px;
}

.pop-tos a {
    display: flex;
    align-feedbacks: center;
    justify-content: center;
    padding: 12px 20px;
    background: rgb(4, 138, 79);
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    border: 1px solid rgb(4, 138, 79);
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    width: 142px;
}

.pop-tos a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.pop-tos .tos1 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.tos1 {
    padding-right: 10px;
    color: #fff;
}

.tos2 {
    color: #fff;
}

table tbody tr {
    border: none;
    border-bottom: 1px solid #eee !important;
}

.pop-tos .tos2 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79) !important;
}

.button {
    /* display: flex; */
    align-feedbacks: center;
    justify-content: center;
    padding: 5px 3px;
    background: rgb(4, 138, 79);
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    border: 1px solid rgb(4, 138, 79);
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease-out;
    width: 82px;
    margin: auto
}

.col-xl-6 {
    flex: 0 0 50%;
    max-width: 31%;
}

.icons {
    background-color: white;
    border-radius: 50%;
    border: 1px solid grey;
    padding: 10px;
}

.comments-row {
    background-color: #f9f9f9;
}

.comment {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.comment-header {
    font-weight: bold;
}

.comment-content {
    margin-top: 5px;
}

.commentss {
    background: #edf7f6;
}
</style>
