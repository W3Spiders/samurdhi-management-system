import { React, useEffect } from "react";
import { usePage } from "@inertiajs/react";
import AppLayout from "../../Layouts/AppLayout";
import Grid from "../../Components/Grid";

export default function FamilyUnitIndex() {
    const { familyUnits } = usePage().props;

    return (
        <AppLayout title="Family Units">
            <Grid title="All family Units">
                {familyUnits && (
                    <table className="table table-hover">
                        <thead>
                            <tr>
                                <th>Family Unit Id</th>
                                <th>Primary Member Id</th>
                                <th>Address</th>
                            </tr>
                        </thead>

                        <tbody>
                            {familyUnits.map((unit) => {
                                return (
                                    <tr key={`family-unit-${unit.id}`}>
                                        <td>{unit.id}</td>
                                        <td>{unit.primary_member_id}</td>
                                        <td>
                                            {unit.address_line_1},
                                            {unit.address_line_2},{unit.city}{" "}
                                            {unit.postal_code}
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                )}
            </Grid>
        </AppLayout>
    );
}
