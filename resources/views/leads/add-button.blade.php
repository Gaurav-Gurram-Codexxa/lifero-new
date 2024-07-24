@role('Super Admin')
<a href="../uploads/lead_sample.xlsx" class="btn btn-primary mx-2"> Download Sample </a>
@endrole
<a href="{{ route('leads.create') }}" class="btn btn-primary">{{__('messages.lead.new_lead')}}</a>
