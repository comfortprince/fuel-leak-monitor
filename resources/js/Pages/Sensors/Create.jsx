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
  sensorTypes,
  storage_tank_id
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
      identifier: '',
      sensor_type: '',
      storage_tank_id: storage_tank_id
    })

    const submit = (e) => {
      e.preventDefault();
      post(route('sensors.store'))
    }

    return (
      <AuthenticatedLayout
        header={
          <h2 className="text-xl font-semibold leading-tight text-gray-800">
            Register Sensor
          </h2>
        }
      >
        <Head title="Storage Tanks" />

        <div className="py-12">
          <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900">
                <form onSubmit={submit}>
                  <div>
                      <InputLabel htmlFor="identifier" value="Identifier" />
  
                      <TextInput
                          id="identifier"
                          type="text"
                          name="identifier"
                          value={data.identifier}
                          className="mt-1 block w-full"
                          autoComplete="username"
                          isFocused={true}
                          onChange={(e) => setData('identifier', e.target.value)}
                      />
  
                      <InputError message={errors.identifier} className="mt-2" />
                  </div>

                  <div className="mt-4">
                      <InputLabel htmlFor="sensor_type" value="Sensor Type" />
  
                      <Select
                        id="sensor_type"
                        value={data.sensor_type}
                        label="sensor Type"
                        onChange={(e) => setData('sensor_type', e.target.value)}
                        sx={{ width: '100%' }}
                      >
                        {sensorTypes.map((sensorType) => (
                          <MenuItem
                            key={sensorType}
                            value={sensorType}
                          >
                            {sensorType}
                          </MenuItem>
                        ))}
                      </Select>
  
                      <InputError message={errors.sensor_type} className="mt-2" />
                  </div>
  
                  <div className="mt-4 flex items-center justify-between">  
                      <SecondaryButton 
                        type='button'
                        onClick={() => {
                          history.back();
                        }}
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