<?php
require "header.php";
?>


<div class="ui container" style="font-size: 18px;" id="myersBriggsTestApp">
    <div class="column ui segment center aligned">
        <h3>MYERS-BRIGGS TYPE INDICATOR</strong></h3>
        <span>By Katharine C. Briggs & Isabel Briggs Myers</span>
    </div>

    <div class="ui segment">
        <form @submit.prevent="submitTest()">
            <h3>Directions:</h3>
            <p>There are no "right" or "wrong" answers to the question.... (continue later)</p>
            <h3>Part 1: Which answer comes closer to telling how many you usually feel or act?</h3>

            <template v-for="item, i in items1" :key="i">
                <div class="grouped fields" v-if="i < 26">
                    <template v-if="i == 24">
                        <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                        <br>
                        item count: {{items1[i].answer.length}}
                        <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                            <div class="ui checkbox" style="margin-left: 15px;">
                                <input :required="items1[i].answer.length ==0 ? true: false" type="checkbox" :name="`choiceItem${i++}`" tabindex="0" v-model="item.answer" :value="c">
                                <label>{{choice}}</label>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <label :for="`item${i}`">{{` ${i+1}. ${item.question}`}}</label>
                        <div :id="`item${i}`" class="field" v-for="choice,c in item.choices" :key="c">
                            <div class="ui radio checkbox" style="margin-left: 15px;">
                                <input required type="radio" :name="`choiceItem${i}`" tabindex="0" class="hidden" v-model="item.answer" :value="c">
                                <label>{{choice}}</label>
                            </div>
                        </div>
                    </template>

                </div>
            </template>


            <div style="margin-top: 20px; margin-bottom: 20px;">
                <h3>Part 2: Which word in each pair appeals to your more?</h3>
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

            <button class="ui button" type="submit">Submit</button>
        </form>

        <!-- results down here -->
        <template v-if="results.raw">
            <div class="ui grid" style="margin-top: 50px;">
                <div class="two wide column" v-for="res, key in results.raw" :key="key">
                    <h3 style="text-align: center;">{{key}}</h3>
                    <h4>Total Points: {{results.raw[key].total}}</h4>
                    <li v-for="item, i in results.raw[key].qc" :key="i">{{item.code}} - {{item.points}}</li>
                </div>


                <h3>Personality Type: {{results.personalityType}}</h3>
                <br>

            </div>
        </template>
        <!-- <table class="ui table">
            <thead>
                <tr>
                    <th>E</th>
                    <th>I</th>
                    <th>S</th>
                    <th>N</th>
                    <th>T</th>
                    <th>F</th>
                    <th>J</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>
                <tr>

                </tr>
            </tbody> -->

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
                        answer: 1
                    },
                    {
                        question: "If you were a teacher, would you rather teach",
                        choices: [
                            "Facts-based courses, or",
                            "Courses inlvolving opinion or theory?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Are you usually",
                        choices: [
                            "A 'Good Mixer with groups of people, or'",
                            "Rather quiet and reserve?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you more often let",
                        choices: [
                            "Your heart rule your head, or",
                            "Your head rule your heart?"
                        ],
                        answer: 1
                    },
                    {
                        question: "In doing something that many other people do, would you rather",
                        choices: [
                            "Invent a way of your own, or",
                            "Do it in the accepted way?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Among your friends are you",
                        choices: [
                            "Full of news about everybody, or",
                            "One of the last to ehar what is going on?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Does the idea of making a list of what you should get done over a weekend",
                        choices: [
                            "Help you, or",
                            "Stress you, or",
                            "Depress you?"
                        ],
                        answer: 1
                    },
                    {
                        question: "When you have a special job to do, do you like to",
                        choices: [
                            "Organize it carefully before you start, or",
                            "Find out what is necessary as you go along?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you tend to have",
                        choices: [
                            "Broad friendships with many different people, or",
                            "Deep friendship with very few people?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you admire more the people who are",
                        choices: [
                            "Normal-acting to never make themselves the center of attention, or",
                            "Too original and individual to care whether they are the center of attention or not"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you prefer to",
                        choices: [
                            "Arrange picnics, parties etc, well in advance, or",
                            "Be free to do whatever to loos like fun when the time comes?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you usually get along better with",
                        choices: [
                            "Realistic people, or",
                            "Imaginative people?"
                        ],
                        answer: 1
                    },
                    {
                        question: "When you are with the group of people, would you usually rather",
                        choices: [
                            "Join in the talkof the group or ",
                            "Stand back and listen first?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Is it a higher compliment to be called",
                        choices: [
                            "A person of real feeling, or",
                            "A consistently reasonable person?"
                        ],
                        answer: 1
                    },
                    {
                        question: "In reading for pleasure, do you",
                        choices: [
                            "Enjoy odd or original ways of saying things, or",
                            "Like writers to say exactly what they mean?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you",
                        choices: [
                            "Talk easily to almost anyone for as long as you have to, or",
                            "Find a lot to say only to certian people or under certain conditions?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Does following a schedule",
                        choices: [
                            "Appeal to you, or",
                            "Cramp you?"
                        ],
                        answer: 1
                    },
                    {
                        question: "When it is settled well in advance that you will do a certain things at a certain time, do you find it",
                        choices: [
                            "Nice to be able to plan accordingly, or",
                            "A little unpleasant to be tied down?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Are you more successful",
                        choices: [
                            "At following a carefully worked plan, or",
                            "At dealing with the unexpected and seeing quickly what should be done?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Would you rather be considered",
                        choices: [
                            "A practical person, or",
                            "An out-of-the-box-thinking person?"
                        ],
                        answer: 1
                    },
                    {
                        question: "In a large group, do you more often",
                        choices: [
                            "Introduce others, or",
                            "Get introduced?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Do you usually",
                        choices: [
                            "Value emotion more than logic, or",
                            "Value logic more than feelings?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Would you rather have as a friend",
                        choices: [
                            "Someone who is always coming up with new ideas, or",
                            "Someone who has both feet on the ground?"
                        ],
                        answer: 1
                    },
                    {
                        question: "Can the new pople you meet tell you what you are interested",
                        choices: [
                            "Right away,",
                            "Only after they really get to know you?"
                        ],
                        answer: 1
                    },
                    {
                        question: "(On this question only, if two answers are true, pick both) In your daily work, do you",
                        choices: [
                            "Usually plan your work so you won't need to work under pressure, or",
                            "Rather enjoy an emergency that makes you work against time, or",
                            "Hate to work under pressure?"
                        ],
                        answer: [0, 2]
                    },
                    {
                        question: "Do you usually",
                        choices: [
                            "Show your feelings freely, or",
                            "Keep your feelings to yourself?",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Scheduled",
                            "Unplanned",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Facts",
                            "Ideas",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Quiet",
                            "Hearty",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Convincing",
                            "Touching",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Imaginative",
                            "Matter-of-fact",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Benefits",
                            "Blessings",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Peacemaker",
                            "Judge",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Systematic",
                            "Spontaneous",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Statement",
                            "Concept",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Reserve",
                            "Talkative",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Analyze",
                            "Sympathize",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Create",
                            "Make",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Determined",
                            "Devoted",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Gentle",
                            "Firm",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Systematic",
                            "Casual",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Certainty",
                            "Theory",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Calm",
                            "Lively",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Justice",
                            "Mercy",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Fascinating",
                            "Sensible",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Firm-minded",
                            "Warm hearted",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Feeling",
                            "Thinking",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Literal",
                            "Figurative",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Anticipation",
                            "Compassion",
                        ],
                        answer: 1
                    },
                    {
                        question: "",
                        choices: [
                            "Hard",
                            "Soft",
                        ],
                        answer: 1
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
                        // console.log(data);
                        this.results = data
                        console.log(this.results);
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