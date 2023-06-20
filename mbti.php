<?php
require "header.php";
?>


<div class="ui container" id="myersBriggsTestApp" st>
    <div class="column ui segment center aligned">
        <h3>MYERS-BRIGGS TYPE INDICATOR</strong></h3>
        <span>By Katharine C. Briggs & Isabel Briggs Myers</span>
    </div>

    <div class="ui segment" style="background-color: #fffad3;">
        <form @submit.prevent="submitTest()" style="margin: 50px;">
            <h3>Directions:</h3>
            <p>There are no "right" or "wrong" answers to the question.... (continue later)</p>
            <h3>Part 1: Which answer comes closer to telling how many you usually feel or act?</h3>

            <template v-for="item, i in items1" :key="i">
                <div class="grouped fields" v-if="i < 26" style="font-size: 18px !important;">
                    <template v-if="i == 24">
                        <label :for="`item${i}`" style="margin-bottom: 15px;">{{` ${i+1}. ${item.question}`}}</label>
                        <br>
                        item count: {{items1[i].answer.length}}
                        <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                            <div class="ui checkbox" style="margin-left: 15px;">
                                <input :required="items1[i].answer && items1[i].answer.length ==0 ? true: false" type="checkbox" :name="`choiceItem${i++}`" tabindex="0" v-model="item.answer" :value="c">
                                <label>{{choice}}</label>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                        <br>
                        <br>
                        <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                            <div class="ui radio checkbox" style="margin-left: 15px;">
                                <input required type="radio" :name="`choiceItem${i}`" tabindex="0" class="hidden" v-model="item.answer" :value="c">
                                <label>{{choice}}</label>
                            </div>
                        </div>
                        <br>
                    </template>

                </div>
            </template>


            <div style="margin-top: 20px; margin-bottom: 20px;">
                <h3>Part 2: Which word in each pair appeals to you more?</h3>
                <span>(Think what word means, not how they look or how they sound)</span>
            </div>


            <div class="ui grid" style="margin-bottom: 20px;">
                <div class="four wide column">
                    <template v-for="item, i in items1" :key="i">
                        <div class="grouped fields" v-if="i > 25 && i < 34">
                            <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                            <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                                <div class="ui radio checkbox" style="margin-left: 15px;">
                                    <input type="radio" :name="`choiceItem${i}`" tabindex="0" class="hidden" v-model="item.answer" :value="c">
                                    <label>{{choice}}</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="four wide column">
                    <template v-for="item, i in items1" :key="i">
                        <div class="grouped fields" v-if="i > 33 && i < 42">
                            <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                            <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                                <div class="ui radio checkbox" style="margin-left: 15px;">
                                    <input type="radio" :name="`choiceItem${i}`" tabindex="0" class="hidden" v-model="item.answer" :value="c">
                                    <label>{{choice}}</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="four wide column">
                    <template v-for="item, i in items1" :key="i">
                        <div class="grouped fields" v-if="i > 41">
                            <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                            <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                                <div class="ui radio checkbox" style="margin-left: 15px;">
                                    <input required type="radio" :name="`choiceItem${i}`" tabindex="0" class="hidden" v-model="item.answer" :value="c">
                                    <label>{{choice}}</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <button class="ui green button" type="submit">Submit</button>
        </form>
        </table>

    </div>

</div>


<script>
    new Vue({
        el: "#myersBriggsTestApp",
        data() {
            return {
                items1: [{
                        question: "When you go somewhere for the day, would you rather",
                        choices: [
                            "Plan what you will do and when, or",
                            "Just go!!"
                        ],
                        answer: null
                    },
                    {
                        question: "If you were a teacher, would you rather teach",
                        choices: [
                            "Facts-based courses, or",
                            "Courses inlvolving opinion or theory?"
                        ],
                        answer: null
                    },
                    {
                        question: "Are you usually",
                        choices: [
                            "A 'Good Mixer with groups of people, or'",
                            "Rather quiet and reserve?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you more often let",
                        choices: [
                            "Your heart rule your head, or",
                            "Your head rule your heart?"
                        ],
                        answer: null
                    },
                    {
                        question: "In doing something that many other people do, would you rather",
                        choices: [
                            "Invent a way of your own, or",
                            "Do it in the accepted way?"
                        ],
                        answer: null
                    },
                    {
                        question: "Among your friends are you",
                        choices: [
                            "Full of news about everybody, or",
                            "One of the last to ehar what is going on?"
                        ],
                        answer: null
                    },
                    {
                        question: "Does the idea of making a list of what you should get done over a weekend",
                        choices: [
                            "Help you, or",
                            "Stress you, or",
                            "Depress you?"
                        ],
                        answer: null
                    },
                    {
                        question: "When you have a special job to do, do you like to",
                        choices: [
                            "Organize it carefully before you start, or",
                            "Find out what is necessary as you go along?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you tend to have",
                        choices: [
                            "Broad friendships with many different people, or",
                            "Deep friendship with very few people?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you admire more the people who are",
                        choices: [
                            "Normal-acting to never make themselves the center of attention, or",
                            "Too original and individual to care whether they are the center of attention or not"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you prefer to",
                        choices: [
                            "Arrange picnics, parties etc, well in advance, or",
                            "Be free to do whatever to loos like fun when the time comes?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you usually get along better with",
                        choices: [
                            "Realistic people, or",
                            "Imaginative people?"
                        ],
                        answer: null
                    },
                    {
                        question: "When you are with the group of people, would you usually rather",
                        choices: [
                            "Join in the talkof the group or ",
                            "Stand back and listen first?"
                        ],
                        answer: null
                    },
                    {
                        question: "Is it a higher compliment to be called",
                        choices: [
                            "A person of real feeling, or",
                            "A consistently reasonable person?"
                        ],
                        answer: null
                    },
                    {
                        question: "In reading for pleasure, do you",
                        choices: [
                            "Enjoy odd or original ways of saying things, or",
                            "Like writers to say exactly what they mean?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you",
                        choices: [
                            "Talk easily to almost anyone for as long as you have to, or",
                            "Find a lot to say only to certian people or under certain conditions?"
                        ],
                        answer: null
                    },
                    {
                        question: "Does following a schedule",
                        choices: [
                            "Appeal to you, or",
                            "Cramp you?"
                        ],
                        answer: null
                    },
                    {
                        question: "When it is settled well in advance that you will do a certain things at a certain time, do you find it",
                        choices: [
                            "Nice to be able to plan accordingly, or",
                            "A little unpleasant to be tied down?"
                        ],
                        answer: null
                    },
                    {
                        question: "Are you more successful",
                        choices: [
                            "At following a carefully worked plan, or",
                            "At dealing with the unexpected and seeing quickly what should be done?"
                        ],
                        answer: null
                    },
                    {
                        question: "Would you rather be considered",
                        choices: [
                            "A practical person, or",
                            "An out-of-the-box-thinking person?"
                        ],
                        answer: null
                    },
                    {
                        question: "In a large group, do you more often",
                        choices: [
                            "Introduce others, or",
                            "Get introduced?"
                        ],
                        answer: null
                    },
                    {
                        question: "Do you usually",
                        choices: [
                            "Value emotion more than logic, or",
                            "Value logic more than feelings?"
                        ],
                        answer: null
                    },
                    {
                        question: "Would you rather have as a friend",
                        choices: [
                            "Someone who is always coming up with new ideas, or",
                            "Someone who has both feet on the ground?"
                        ],
                        answer: null
                    },
                    {
                        question: "Can the new people you meet tell you what you are interested",
                        choices: [
                            "Right away,",
                            "Only after they really get to know you?"
                        ],
                        answer: null
                    },
                    {
                        question: "(On this question only, if two answers are true, pick both) In your daily work, do you",
                        choices: [
                            "Usually plan your work so you won't need to work under pressure, or",
                            "Rather enjoy an emergency that makes you work against time, or",
                            "Hate to work under pressure?"
                        ],
                        answer: []
                    },
                    {
                        question: "Do you usually",
                        choices: [
                            "Show your feelings freely, or",
                            "Keep your feelings to yourself?",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Scheduled",
                            "Unplanned",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Facts",
                            "Ideas",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Quiet",
                            "Hearty",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Convincing",
                            "Touching",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Imaginative",
                            "Matter-of-fact",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Benefits",
                            "Blessings",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Peacemaker",
                            "Judge",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Systematic",
                            "Spontaneous",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Statement",
                            "Concept",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Reserve",
                            "Talkative",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Analyze",
                            "Sympathize",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Create",
                            "Make",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Determined",
                            "Devoted",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Gentle",
                            "Firm",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Systematic",
                            "Casual",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Certainty",
                            "Theory",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Calm",
                            "Lively",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Justice",
                            "Mercy",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Fascinating",
                            "Sensible",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Firm-minded",
                            "Warm hearted",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Feeling",
                            "Thinking",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Literal",
                            "Figurative",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Anticipation",
                            "Compassion",
                        ],
                        answer: null
                    },
                    {
                        question: "",
                        choices: [
                            "Hard",
                            "Soft",
                        ],
                        answer: null
                    },
                ],
                results: {}
            }
        },
        methods: {
            submitTest() {

                $.post("mbti_proc.php", {
                        submitTest: true,
                        items: this.items1
                    },
                    (data, textStatus, jqXHR) => {
                        console.log(data);
                        // this.results = data
                        // console.log(this.results);
                        window.history.back();
                    },
                    "json"
                );
            },
        },
        mounted() {
            $('.ui.radio.checkbox')
                .checkbox();
        }
    })
</script>

<?php
require "footer.php";
?>