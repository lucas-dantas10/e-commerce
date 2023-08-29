<template>
    <div>
        <label class="sr-only">{{ label }}</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <span v-if="prepend"
                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                {{ prepend }}
            </span>
            <template v-if="type === 'select'">
                
                <select :name="name" :required="required" :value="modelInput" :class="inputClasses"
                    @change="onChange($event.target.value)">
                    <option v-for="option of selectOptions" :value="option.key">{{ option.text }}</option>
                </select>
            </template>

            <template v-else-if="type === 'textarea'">
                <textarea :name="name" :required="required" :value="modelInput"
                    @input="$emit('update:modelInput', $event.target.value)" :class="inputClasses"
                    :placeholder="label">
                </textarea>
            </template>

            <template v-else-if="type === 'file'">
                <input 
                    :type="type" 
                    :name="name" 
                    :required="required" 
                    :value="modelInput"
                    @input="$emit('change', $event.target.files[0])" 
                    :class="inputClasses" 
                    :placeholder="label" 
                />
            </template>

            <template v-else-if="type === 'checkbox'">
                <input 
                    :id="id"
                    :name="name" 
                    :type="type" 
                    :checked="modelInput" 
                    :required="required"
                    @change="$emit('update:modelInput', $event.target.checked)"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                />
                <label :for="id" class="ml-2 block text-sm text-gray-900"> {{ label }} </label>
            </template>

            <template v-else>
                <input 
                    :type="type" 
                    :name="name" 
                    :required="required" 
                    :value="modelInput"
                    @input = "$emit('update:modelInput', $event.target.value)" 
                    :class="inputClasses" 
                    :placeholder="label"
                    step="0.01" 
                />
            </template>

            <span v-if="append"
                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                {{ append }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        modelInput: [String, Number, File, Boolean],
        type: {
            type: String,
            default: 'text'
        },
        name: String,
        required: Boolean,
        prepend: {
            type: String,
            default: ''
        },
        append: {
            type: String,
            default: ''
        },
        selectOptions: Array
    },

    emits: ['change', 'update:modelInput'],

    methods: {
        onChange(value) {
            this.$emit('update:modelInput', value);
            this.$emit('change', value);
        },
    },

    computed: {
        id() {
            if (this.id) return this.id;

            return `id-${Math.floor(100000 + Math.random() * 100000)}`;
        },

        inputClasses() {
            const cls = [
                `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm`,
            ];
            if (this.append && !this.prepend) {
                cls.push(`rounded-l-md`)
            } else if (this.prepend && !this.append) {
                cls.push(`rounded-r-md`)
            } else if (!this.prepend && !this.append) {
                cls.push('rounded-md')
            }
            return cls.join(' ')
        }
    }
}

</script>