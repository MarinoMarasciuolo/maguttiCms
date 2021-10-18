@if($item->isEditable())
    <div class="bool-toggle" data-list-boolean="{!! $item->model_name.'_'.$item->getId() !!}"
         data-list-name="{!! $item->getItemProperty('field')!!}">
        <span class="bool-on {{($item->getValue())? '' : 'd-none'}}">
            {{AdminDecorator::getBooleanOn()}}
        </span>
            <span class="bool-off {{($item->getValue())? 'd-none' : ''}}">
           {{AdminDecorator::getBooleanOff()}}
        </span>
    </div>
@else
    <div class="bool-toggle">
        @if ($item->getValue() == 1)
            <i class="text-success h2">{{AdminDecorator::getBooleanOn()}}</i>
        @else
            <i class="text-danger h2">{{AdminDecorator::getBooleanOff()}}</i>
        @endif
    </div>
@endif
