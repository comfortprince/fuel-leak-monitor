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
    storageTank,
    fuelTypes
}) {
    const { data, setData, put, processing, errors } = useForm({
      identifier: storageTank.identifier,
      fuel_type: storageTank.fuel_type,
      location: storageTank.location
    })

    const submit = (e) => {
      e.preventDefault();
      put(route('storage-tanks.update', storageTank.id))
    }

    return (
      <AuthenticatedLayout
        header={
          <h2 className="text-xl font-semibold leading-tight text-gray-800">
            Edit {storageTank.identifier}
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
                      <InputLabel htmlFor="fuel_type" value="Fuel Type" />
  
                      <Select
                        id="fuel_type"
                        value={data.fuel_type}
                        label="Fuel Type"
                        onChange={(e) => setData('fuel_type', e.target.value)}
                        sx={{ width: '100%' }}
                      >
                        {fuelTypes.map((fuelType) => (
                          <MenuItem
                            key={fuelType}
                            value={fuelType}
                          >
                            {fuelType}
                          </MenuItem>
                        ))}
                      </Select>
  
                      <InputError message={errors.fuel_type} className="mt-2" />
                  </div>

                  <div className="mt-4">
                      <InputLabel htmlFor="location" value="Location" />
  
                      <TextInput
                          id="location"
                          type="text"
                          name="location"
                          value={data.location}
                          className="mt-1 block w-full"
                          onChange={(e) => setData('location', e.target.value)}
                      />
  
                      <InputError message={errors.location} className="mt-2" />
                  </div>
  
                  <div className="mt-4 flex items-center justify-between">  
                      <Link href={route('storage-tanks.index')}>
                        <SecondaryButton type='button'>
                          Cancel
                        </SecondaryButton>
                      </Link>
                      
                      <PrimaryButton className="ms-4" disabled={processing}>
                          Save
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