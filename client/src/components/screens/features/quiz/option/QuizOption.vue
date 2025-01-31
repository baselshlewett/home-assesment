<template>
    <div class="option" :class="{'checked': selectedAnswer === option.id}">
        <input
            type="radio"
            :name="`question_${questionNumber}`"
            :id="`question_${index}_options_${index}`"
            :value="option.id"
            :checked="selectedAnswer === option.id"
            :disabled="isReadOnly"
            :class="{'radio': true, ...getOptionBackgroundClass()}"
            @change="onChange"
            />
        <label
            :for="`question_${index}_options_${index}`">
            <span class="option_index">
                {{String.fromCharCode((index+ 1) + 64)}}
            </span>
            <span class="option_text">
                {{ option.option_text }}
            </span>
        </label>
        <span v-if="isReadOnly && userAnswer === option.id" class="answer_icon_container">
            <span v-if="option.is_correct">
                <CheckCircle class="check" />
            </span>
            <span v-else>
                <TimesCircle class="times" />
            </span>
        </span>
    </div>
</template>

<script>
import CheckCircle from '@/assets/check_circle.svg?component'
import TimesCircle from '@/assets/times_circle.svg?component'

export default {
    name: 'QuizOption',
    components: { CheckCircle, TimesCircle },
    props: {
        option: {
            type: Object,
            required: true
        },
        index: {
            type: Number,
            required: true
        },
        selectedAnswer: {
            type: Number,
            required: false
        },
        questionNumber: {
            type: Number,
            required: true
        },
        isReadOnly: {
            type: Boolean,
            required: false
        },
        userAnswer: {
            type: Number,
            required: false
        },
    },
    data() {
        return {}
    },
    methods: {
        onChange() {
            this.$emit('update:selectedAnswer', this.option.id)
        },
        getOptionBackgroundClass() {
            if (this.isReadOnly) {
                return {
                    correct_answer: this.userAnswer === this.option.id && this.option.is_correct,
                    incorrect_answer: this.userAnswer === this.option.id && !this.option.is_correct
                }
            }
            return {};
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.option {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 10px;
    position: relative;

    label {
        display: flex;
        flex: 1;
        justify-content: flex-start;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: $BORDER_THIN;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s;

        &:hover {
            background-color: $BLUE_EGGSHELL;
        }

        .option_index {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: $FONT_SIZE_S;
            font-family: $FONT_BOLD;
            border: $BORDER;
            border-radius: 50%;
            padding: 2px;
            width: 20px;
            height: 20px;
        }

        .option_text {
            font-size: $FONT_SIZE_S;
            font-family: $FONT_REGULAR;
        }
    }
}

.radio {
    display: none; 
}

.radio:checked {
    +label {
        background-color: $LIGHT_BLUE; 
        border-color: $BLUE_FOCUS;

        .option_index {
            border-color: $TEAL;
            background-color: $DROPDOWN_HOVER;
        }
    }
}

.radio:checked.correct_answer {
    + label {
        background-color: $HONEYDEW;
        border-color: $CHECKMARK_GREEN;
        color: $VADER;
    }
}

.radio:checked.incorrect_answer {
    + label {
        background-color: $ERROR_MESSAGE_BACKGROUND;
        border: $BORDER;
        border-color: $SUNSET_RED;
        color: $VADER;
    }
}

.answer_icon_container {
    display: flex;
    align-items: center;
    position: absolute;
    left: 100%;
    margin-left: 10px;
    
    .check,
    .times {
        width: 15px;
    }

    .check {
        color: #28a745;
    }

    .times {
        color: #dc3545;
    }
}
</style>