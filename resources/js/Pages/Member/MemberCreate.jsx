import {
    Button,
    TextField,
    Box,
    Card,
    FormControl,
    RadioGroup,
    FormLabel,
    FormControlLabel,
    Select,
    Radio,
    MenuItem,
    Alert,
} from "@mui/material";
import AppLayout from "../../Layouts/AppLayout";
import { DateField, LocalizationProvider } from "@mui/x-date-pickers";
import { AdapterMoment } from "@mui/x-date-pickers/AdapterMoment";
import moment from "moment";
import { useForm, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

class MemberFormValue {
    firstName = "";
    middleName = "";
    lastName = "";
    email = "";
    phone = "";
    race = "";
    gender = "";
    birthday = "";
    nic = "";
    monthlyIncome = 0;
    maritalStatus = "";
    hasIncome = "";
    monthlyIncome = "";
}

export default function FamilyUnitMemberCreate() {
    const { data, setData, post, processing, errors, setError, wasSuccessful } =
        useForm(new MemberFormValue());
    const { familyUnit } = usePage().props;

    const [familyUnitId, setFamilyUnitId] = useState(null);

    const maxDate = new moment();

    function handleSubmit(e) {
        e.preventDefault();
        post(route("member.store"));
    }

    useEffect(() => {
        setFamilyUnitId(familyUnit.id);
        setData({ ...data, familyUnitId: familyUnitId });
    });

    return (
        <>
            <AppLayout title="Create Member">
                <Card style={{ maxWidth: 600 }}>
                    <Box padding={3}>
                        <form>
                            <div className="form-section">
                                <div className="form-section-title">
                                    Main Information
                                </div>
                                <div className="form-row row">
                                    <div className="col-md-6">
                                        <TextField
                                            id="firstName"
                                            label="First Name"
                                            variant="outlined"
                                            value={data.firstName}
                                            onChange={(e) => {
                                                setError("firstName", "");

                                                setData({
                                                    ...data,
                                                    firstName: e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.firstName && (
                                            <Alert severity="error">
                                                {errors.firstName}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <TextField
                                            id="middleName"
                                            label="Middle Name"
                                            variant="outlined"
                                            value={data.middleName}
                                            onChange={(e) => {
                                                setError("middleName", "");

                                                setData({
                                                    ...data,
                                                    middleName: e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.middleName && (
                                            <Alert severity="error">
                                                {errors.middleName}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <TextField
                                            id="lastName"
                                            label="Last Name"
                                            variant="outlined"
                                            value={data.lastName}
                                            onChange={(e) => {
                                                setError("lastName", "");

                                                setData({
                                                    ...data,
                                                    lastName: e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.lastName && (
                                            <Alert severity="error">
                                                {errors.lastName}
                                            </Alert>
                                        )}
                                    </div>
                                </div>

                                <div className="form-row row">
                                    <div className="col-md-6">
                                        <TextField
                                            id="email"
                                            label="Email"
                                            variant="outlined"
                                            value={data.email}
                                            onChange={(e) => {
                                                setError("email", "");

                                                setData({
                                                    ...data,
                                                    email: e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.email && (
                                            <Alert severity="error">
                                                {errors.email}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <TextField
                                            id="phone"
                                            label="Phone"
                                            variant="outlined"
                                            value={data.phone}
                                            onChange={(e) => {
                                                setError("phone", "");

                                                setData({
                                                    ...data,
                                                    phone: e.target.value,
                                                });
                                            }}
                                        />
                                        {errors.phone && (
                                            <Alert severity="error">
                                                {errors.phone}
                                            </Alert>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <div className="form-section">
                                <div className="form-section-title">
                                    Personal Information
                                </div>
                                <div className="row">
                                    <div className="col-md-6">
                                        <FormControl>
                                            <FormLabel
                                                id="gender-label"
                                                htmlFor="gender"
                                            >
                                                Gender
                                            </FormLabel>
                                            <RadioGroup
                                                defaultChecked={false}
                                                name="gender"
                                                row={true}
                                                value={data.gender}
                                                onChange={(e) => {
                                                    setError("gender", "");

                                                    setData({
                                                        ...data,
                                                        gender: e.target.value,
                                                    });
                                                }}
                                            >
                                                <FormControlLabel
                                                    value="m"
                                                    control={<Radio />}
                                                    label="Male"
                                                />
                                                <FormControlLabel
                                                    value="f"
                                                    control={<Radio />}
                                                    label="Female"
                                                />
                                            </RadioGroup>
                                        </FormControl>

                                        {errors.gender && (
                                            <Alert severity="error">
                                                {errors.gender}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <LocalizationProvider
                                            dateAdapter={AdapterMoment}
                                        >
                                            <DateField
                                                id="birthday"
                                                format="YYYY-MM-DD"
                                                maxDate={maxDate}
                                                value={data.birthday}
                                                onChange={(momentDate) => {
                                                    setError("birthday", "");

                                                    setData({
                                                        ...data,
                                                        birthday: momentDate
                                                            ? momentDate.format(
                                                                  "YYYY-MM-DD"
                                                              )
                                                            : null,
                                                    });
                                                }}
                                            />
                                        </LocalizationProvider>

                                        {errors.birthday && (
                                            <Alert severity="error">
                                                {errors.birthday}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <FormControl fullWidth>
                                            <FormLabel id="race-label">
                                                Race
                                            </FormLabel>
                                            <Select
                                                labelId="race-label"
                                                id="race-select"
                                                label="Race"
                                                value={data.race}
                                                onChange={(e) => {
                                                    setError("race", "");

                                                    setData({
                                                        ...data,
                                                        race: e.target.value,
                                                    });
                                                }}
                                            >
                                                <MenuItem value={"sinhala"}>
                                                    Sinhala
                                                </MenuItem>
                                                <MenuItem value={"tamil"}>
                                                    Tamil
                                                </MenuItem>
                                                <MenuItem value={"muslim"}>
                                                    Muslim
                                                </MenuItem>
                                                <MenuItem value={"other"}>
                                                    Other
                                                </MenuItem>
                                            </Select>
                                        </FormControl>
                                        {errors.race && (
                                            <Alert severity="error">
                                                {errors.race}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <TextField
                                            id="nic"
                                            label="NIC"
                                            variant="outlined"
                                            value={data.nic}
                                            onChange={(e) => {
                                                setError("nic", "");

                                                setData({
                                                    ...data,
                                                    nic: e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.nic && (
                                            <Alert severity="error">
                                                {errors.nic}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <FormControl>
                                            <FormLabel
                                                id="marital-status-label"
                                                htmlFor="marital-status"
                                            >
                                                Marital Status
                                            </FormLabel>
                                            <RadioGroup
                                                defaultChecked={false}
                                                id="marital-status"
                                                row={true}
                                                value={data.maritalStatus}
                                                onChange={(e) => {
                                                    setError(
                                                        "maritalStatus",
                                                        ""
                                                    );

                                                    setData({
                                                        ...data,
                                                        maritalStatus:
                                                            e.target.value,
                                                    });
                                                }}
                                            >
                                                <FormControlLabel
                                                    value="single"
                                                    control={<Radio />}
                                                    label="Single"
                                                />

                                                <FormControlLabel
                                                    value="married"
                                                    control={<Radio />}
                                                    label="Married"
                                                />
                                            </RadioGroup>
                                        </FormControl>

                                        {errors.maritalStatus && (
                                            <Alert severity="error">
                                                {errors.maritalStatus}
                                            </Alert>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <div className="form-section">
                                <div className="form-section-title">
                                    Financial Information
                                </div>

                                <div className="form-row row">
                                    <div className="col-md-12">
                                        <FormControl>
                                            <FormLabel
                                                id="has-income-method-label"
                                                htmlFor="has-income-method"
                                            >
                                                Has an income method?
                                            </FormLabel>
                                            <RadioGroup
                                                id="has-income-method"
                                                row={true}
                                                defaultChecked={false}
                                                value={data.hasIncome}
                                                onChange={(e) => {
                                                    setError("hasIncome", "");

                                                    setData({
                                                        ...data,
                                                        hasIncome:
                                                            e.target.value,
                                                    });
                                                }}
                                            >
                                                <FormControlLabel
                                                    value={1}
                                                    control={<Radio />}
                                                    label="Yes"
                                                />

                                                <FormControlLabel
                                                    value={0}
                                                    control={<Radio />}
                                                    label="No"
                                                />
                                            </RadioGroup>
                                        </FormControl>

                                        {errors.hasIncome && (
                                            <Alert severity="error">
                                                {errors.hasIncome}
                                            </Alert>
                                        )}
                                    </div>

                                    <div className="col-md-6">
                                        <TextField
                                            id="monthlyIncome"
                                            label="Monthly Income(Rs.)"
                                            variant="outlined"
                                            type="number"
                                            value={data.monthlyIncome}
                                            onChange={(e) => {
                                                setError("monthlyIncome", "");

                                                setData({
                                                    ...data,
                                                    monthlyIncome:
                                                        e.target.value,
                                                });
                                            }}
                                        />

                                        {errors.monthlyIncome && (
                                            <Alert severity="error">
                                                {errors.monthlyIncome}
                                            </Alert>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div
                            style={{
                                display: "flex",
                                justifyContent: "end",
                                gap: 10,
                            }}
                        >
                            <Button variant="contained" color="secondary">
                                Cancel
                            </Button>
                            <Button
                                variant="contained"
                                onClick={handleSubmit}
                                disabled={processing}
                            >
                                Save
                            </Button>
                        </div>

                        {wasSuccessful && (
                            <div style={{ marginBottom: 10 }}>
                                <Alert severity="success">
                                    Member was created successfully.
                                </Alert>
                            </div>
                        )}
                    </Box>
                </Card>
            </AppLayout>
        </>
    );
}
