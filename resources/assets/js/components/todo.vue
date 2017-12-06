<template>
    <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
        <div class="mb-4">
            <h1 class="text-grey-darkest">Todo List</h1>
            <div class="flex mt-4">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker" v-model="newTodo" placeholder="Add Todo">
                <button class="flex-no-shrink p-2 border-2 rounded text-teal border-teal hover:text-white hover:bg-teal" @click="add" :disabled="newTodo.length === 0">Add</button>
            </div>
        </div>
        <div>
            <div class="flex mb-4 items-center" v-for="(todo, index) in todos" :key="todo.id">
                <p class="w-full" :class="todo.finished ? 'line-through text-green' : 'text-grey-darkest'">{{todo.text}}</p>
                <button class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded hover:text-white" :class="todo.finished ? 'text-grey border-grey hover:bg-grey' : 'text-green border-green hover:bg-green'" @click="updateStatus(todo)" v-text="todo.finished ? 'Not Done' : 'Done'"></button>
                <button class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red" @click="remove(index)">Remove</button>
            </div>
            <div v-show="todos.length === 0">
                <p class="w-full text-center text-grey-dark">There are no todos</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                todos: [],
                newTodo: '',
                baseId: 1,
            }
        },
        methods: {
            add() {
              const t = this;

              let todo = {
                id: t.baseId,
                text: t.newTodo,
                finished: false,
              }

              t.todos.unshift(todo);

              t.newTodo = '';
              t.baseId++;
            },
            updateStatus(todo) {
              todo.finished = !todo.finished;
            },
            remove(index) {
              const t = this;

              t.todos.splice(index, 1);
            }
        }
    }
</script>
