import { Head, Link, useForm } from '@inertiajs/react';

import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';

export default function Index({
  storageTank
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        storage_tank_id : storageTank.id,
        mq2_min : '',
        mq2_max : '',
        bmp180_min : '',
        bmp180_max : '',
        level : '',
        description : '',
        action_required : '',
    })

    const submit = (e) => {
      e.preventDefault();
      post(route('custom-alerts.store'))
    }

    return (
      <AuthenticatedLayout
        header={
          <h2 className="text-xl font-semibold leading-tight text-gray-800">
            Create Custom Alert
          </h2>
        }
      >
        <Head title="Storage Tanks" />

        <div className="py-12">
          <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900">
                <form onSubmit={submit}>
                  <div className="mt-4">
                      <InputLabel htmlFor="storage_tank" value="Storage Tank" />
  
                      <TextInput
                          type="text"
                          name="storage_tank"
                          id="storage_tank"
                          value={storageTank.identifier}
                          className="mt-1 block w-full"
                          disabled
                      />
                  </div>
                  
                  <div>
                      <InputLabel htmlFor="mq2_min" value="MQ2 min" />
  
                      <TextInput
                          id="mq2_min"
                          type="text"
                          name="mq2_min"
                          value={data.mq2_min}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('mq2_min', e.target.value)}
                      />
  
                      <InputError message={errors.mq2_min} className="mt-2" />
                  </div>

                  <div>
                      <InputLabel htmlFor="mq2_max" value="MQ2 max" />
  
                      <TextInput
                          id="mq2_max"
                          type="text"
                          name="mq2_max"
                          value={data.mq2_max}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('mq2_max', e.target.value)}
                      />
  
                      <InputError message={errors.mq2_max} className="mt-2" />
                  </div>

                  <div>
                      <InputLabel htmlFor="bmp180_min" value="BMP180 min" />
  
                      <TextInput
                          id="bmp180_min"
                          type="text"
                          name="bmp180_min"
                          value={data.bmp180_min}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('bmp180_min', e.target.value)}
                      />
  
                      <InputError message={errors.bmp180_min} className="mt-2" />
                  </div>

                  <div>
                      <InputLabel htmlFor="bmp180_max" value="BMP180 max" />
  
                      <TextInput
                          id="bmp180_max"
                          type="text"
                          name="bmp180_max"
                          value={data.bmp180_max}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('bmp180_max', e.target.value)}
                      />
  
                      <InputError message={errors.bmp180_max} className="mt-2" />
                  </div>

                  <div className="mt-4">
                      <InputLabel htmlFor="level" value="Level" />
  
                      <Select
                        id="level"
                        value={data.level}
                        label="Level"
                        onChange={(e) => setData('level', e.target.value)}
                        sx={{ width: '100%' }}
                      >
                        {['warning', 'danger'].map((_level) => (
                          <MenuItem
                            key={_level}
                            value={_level}
                          >
                            {_level}
                          </MenuItem>
                        ))}
                      </Select>
  
                      <InputError message={errors.level} className="mt-2" />
                  </div>

                  <div>
                      <InputLabel htmlFor="description" value="Description" />
  
                      <TextInput
                          id="description"
                          type="text"
                          name="description"
                          value={data.description}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('description', e.target.value)}
                      />
  
                      <InputError message={errors.description} className="mt-2" />
                  </div>

                  <div>
                      <InputLabel htmlFor="action_required" value="Action Required" />
  
                      <TextInput
                          id="action_required"
                          type="text"
                          name="action_required"
                          value={data.action_required}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('action_required', e.target.value)}
                      />
  
                      <InputError message={errors.action_required} className="mt-2" />
                  </div>
  
                  <div className="mt-4 flex items-center justify-between">  
                      <SecondaryButton 
                        type='button'
                        onClick = { () => { window.history.back(); } }
                      >
                          Cancel
                      </SecondaryButton>
                      
                      <PrimaryButton className="ms-4" disabled={processing}>
                          Create
                      </PrimaryButton>
                  </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    );
}