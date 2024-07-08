import React from 'react'
import Layout from '../../Shared/Layout'
import { useForm } from '@inertiajs/react'
import Input from '../../Shared/Input'
import InputSelect from '../../Shared/InputSelect'

const Create = () => {

    const { data, setData, post, errors, } = useForm({
        name: "",
        email: "",
        role: "staff",
        password: "",
        confirm_password: "",
    })

    const onSubmit = (e) => {
        e.preventDefault()
        post("/setting-users")
    }

    return (
        <Layout left={"Users / Create"} right={<></>}>
            <div className="col-12 col-sm-6">
                <FormAdd data={data} setData={setData} errors={errors} onSubmit={onSubmit} />
            </div>
        </Layout>
    )
}

export default Create


const FormAdd = ({ onSubmit, data, errors, setData }) => {
    const submit = (e) => {
        e.preventDefault()
        onSubmit(data)
    }

    return (
        <form onSubmit={submit}>
            <div className="card">
                <div className="card-body">
                    <div className="mb-3">
                        <Input
                            label="Name"
                            isRequired
                            placeholder="Name"
                            onChange={e => setData("name", e.target.value)}
                            error={errors.name}
                            value={data.name}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            label="Email"
                            isRequired
                            placeholder="Email"
                            onChange={e => setData("email", e.target.value)}
                            error={errors.email}
                            value={data.email}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            isRequired
                            label="Password"
                            placeholder="Password"
                            onChange={e => setData("password", e.target.value)}
                            error={errors.password}
                            value={data.password}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            isRequired
                            label="Confirm Password"
                            placeholder="Confirm Password"
                            onChange={e => setData("confirm_password", e.target.value)}
                            error={errors.confirm_password}
                            value={data.confirm_password}
                        />
                    </div>
                    <div className="mb-3">
                        <InputSelect
                            isRequired
                            placeholder={"Role"}
                            label={"Role"}
                            options={[
                                { label: "Staff", value: "staff" },
                                { label: "Finance", value: "finance" },
                                { label: "Owner", value: "owner" },
                            ]}
                            onChange={e => setData("role", e.target.value)}
                            value={data.role}
                            error={errors.role}
                        />
                    </div>
                </div>
                <div className="card-footer text-end">
                    <button className='btn btn-primary' onClick={onSubmit}>Save</button>
                </div>
            </div>
        </form>
    )
}
