@if(isset($weather_data->error))
    <p style="text-align: center; color:red">{{$weather_data->error->message}}</p>
@else
    <table>
        <thead>
        <tr>
            <td>Temperature
            </td>

            <td>Condition</td>
            <td>Image</td>
            <td>Wind mph</td>
            <td>Wind kph</td>
            <td>Humidity</td>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td class="temp">{{$weather_data->current->temp_c}}</td>
            <td>{{$weather_data->current->condition->text}}</td>
            <td><img src="{{$weather_data->current->condition->icon}}"/></td>
            <td>{{$weather_data->current->wind_mph}}</td>
            <td>{{$weather_data->current->wind_kph}}</td>
            <td>{{$weather_data->current->humidity}}</td>
        </tr>
        </tbody>
    </table>

    <label>
        <select name="select_type" onchange="getValue({{json_encode($weather_data->current)}}, this);">
            <option value="temp_c">Celsius</option>
            <option value="temp_f">Fahrenheit</option>
        </select>
    </label>
@endif

