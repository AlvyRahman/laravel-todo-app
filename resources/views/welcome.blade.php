<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>To-Do list app</title>

        <style>
            /* CSS */
            .button-4 {
            appearance: none;
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            border-radius: 5px;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            box-sizing: border-box;
            color: #24292E;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 12px;
            font-weight: 500;
            line-height: 20px;
            list-style: none;
            padding: 3px 9px;
            position: relative;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
            word-wrap: break-word;
            }

            .button-4:hover {
            background-color: #F3F4F6;
            text-decoration: none;
            transition-duration: 0.1s;
            }

            .button-4:disabled {
            background-color: #FAFBFC;
            border-color: rgba(27, 31, 35, 0.15);
            color: #959DA5;
            cursor: default;
            }

            .button-4:active {
            background-color: #EDEFF2;
            box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
            transition: none 0s;
            }

            .button-4:focus {
            outline: 1px transparent;
            }

            .button-4:before {
            display: none;
            }

            .button-4:-webkit-details-marker {
            display: none;
            }

            label {
            color: black;
            font-weight: 600;
            display: block;
            }

            input {
                padding: 3px;
                box-shadow: 1px 1px 3px black;
                font-size: 14px;
                font-weight: 500;
                width: 160px;
            }

            p {
                font-size: 20px;
                font-weight: 600;
            }
        </style>
    </head>

    <body style="background: linear-gradient(to right, #ff9966, #ff5e62);">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div>
                <h1 style="display: flex;
                        justify-content: center;
                        align-items: center;
                        text-align: center;"> To-Do List </h1> </br>

                <div style="display: flex;
                        justify-content: center;
                        align-items: center;
                        text-align: center;">
                    <form method="post" action="{{ route('markAllComplete') }}">
                        {{ csrf_field() }}
                        <button class="button-4" type="submit" style="margin-left: 20px; color: green;"> All Complete </button>
                    </form>

                    <form method="post" action="{{ route('markAllIncomplete') }}">
                        {{ csrf_field() }}
                        <button class="button-4" type="submit" style="margin-left: 20px; color: orange;"> All Incomplete </button>
                    </form>
                </div>
                
                @foreach ($listItems as $listItem)
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <p> {{ $listItem->name }} </p>

                        <form method="post" action="{{ route('complete', $listItem->id) }}">
                            {{ csrf_field() }}
                            <button class="button-4" type="submit" style="margin-left: 20px; color: green;"> Complete </button>
                        </form>

                        <form method="post" action="{{ route('remove', $listItem->id) }}">
                            {{ csrf_field() }}
                            <button class="button-4" type="submit" style="margin-left: 20px; color: red;"> Remove </button>
                        </form>
                    </div>
                @endforeach
                <br>

                <div style="display: flex;
                        justify-content: center;
                        align-items: center;
                        text-align: center;">
                    <form method="post" action="{{ route('saveItem') }}">
                        {{ csrf_field() }}
                        <label for="listItem"> New Item </label> </br>
                        <input type="text" name="listItem"> </br>
                        <button class="button-4" type="submit" style="color: green;"> Save Item </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
